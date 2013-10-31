<?php
/**
 * Модель User
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $state
 */
class User extends CActiveRecord
{

    public $password_repeat;
    public $rememberMe;

    private $_last_visit_date;
    private $_register_date;
    private $_identity;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return array(
            array('image', 'file',
                'allowEmpty' => true,
                'types'      => 'gif, jpg, jpeg, png',
                //'mimeTypes'  => 'image/gif, image/jpeg, image/png',
                'maxSize'    => 500000,
                'maxFiles'   => 1,
            ),
            array('nickname, email, password, password_repeat', 'required', 'on'=>'register'),
            array('password', 'compare', 'compareAttribute'=>'password_repeat', 'on'=>'register'),
            array('nickname, email', 'validBusyItemFieldName', 'on'=>'register'),
            array('email', 'email'),
            array('nickname', 'validNickName'),
            array('nickname', 'validBusyNickNameForProfile', 'on'=>'profile'),
            array('nickname,', 'required', 'on'=>'profile'),
            array('nickname, email, password, password_repeat', 'filter', 'filter'=>'trim'),
        );
    }

    public function validNickName($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if(!$this::isCorrectNickName($this->{$attribute}))
            {
                $this->addError($attribute,'Uncorrect NickName');
            }
        }
    }

    public function validBusyItemFieldName($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            if($this::isBusyItemFieldName($attribute, $this->{$attribute}))
            {
                $attrContent = $this->{$attribute};
                $this->addError($attribute, "$attrContent is already in use");
            }
        }
    }

    public function validBusyNickNameForProfile($attribute,$params){
        if(!$this->hasErrors())
        {
            if($this::isBusyItemFieldName($attribute, $this->{$attribute}, $this->id))
            {
                $attrContent = $this->{$attribute};
                $this->addError($attribute, "$attrContent is already in use");
            }
        }
    }

    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }

    protected function beforeSave(){
        if($this->isNewRecord)
            $this->password = md5($this->password);

        return parent::beforeSave();
    }

    public function getAvatarUrl()
    {
        return "/uploads/users/$this->id/$this->avatar";
    }

    public function isBlocked()
    {
        return $this->state==UserStateEnum::USER_BLOCKED;
    }

    public function attributeLabels()
    {
        return array(
            'nickname'=>'Прозвище',
            'state'=>'Состояние',
            'email'=>'Email',
            'register_date'=>'Дата регистрации',
            'last_visit_date'=>'Последний визит',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        if( $this->register_date > 0 )
        {
            $criteria->addCondition('register_date >= :register_date_down AND register_date <= :register_date_up');
            $criteria->params = array(
                ':register_date_down'=>$this->register_date,
                ':register_date_up'=>($this->register_date+3600*24)
            );
        }

        if( $this->last_visit_date > 0 )
        {
            $criteria->addCondition('last_visit_date >= :last_visit_date_down AND last_visit_date <= :last_visit_date_up');
            $criteria->params = array(
                ':last_visit_date_down'=>$this->last_visit_date,
                ':last_visit_date_up'=>($this->last_visit_date+3600*24)
            );
        }

        $criteria->compare('name', $this->name, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getRegister_date()
    {
        if($this->scenario == 'search')
        {
            $this->_register_date = date("d.m.Y",$this->register_date);
        }
        else
        {
            $this->_register_date =  $this->register_date;
        }

        return $this->_register_date;
    }

    public function behaviors() {
        return array(
            'imgBehavior' => array(
                'class' => 'common.extensions.uploaderbehavior.ImageARBehavior',
                'processor' => 'common.extensions.uploaderbehavior.image.Image',
                'attribute' => 'image', // this must exist
                'extension' => 'png, gif, jpg, jpeg', // possible extensions, comma separated
                'prefix' => 'img_',
                'relativeWebRootFolder' => 'uploads/users', // this folder must exist

                'formats' => array(
                    // create a thumbnail grayscale format
                    'thumb' => array(
                        'suffix' => '_thumb',
                        'process' => array('resize' => array(60, 60)),
                    ),
                    // and override the default :
                    'normal' => array(
                        'process' => array('resize' => array(200, 200)),
                    ),
                )
            )
        );
    }

    public function afterSave()
    {
        if ($this->image && strpos($this->imgBehavior->extension, $this->image->extensionName) !== FALSE)
        {
            $path = $this->imgBehavior->getFolderPath().'/'.$this->id;

            if(!is_dir($path))
            {
                mkdir($path, 0777, true);
                chmod($path, 0777);
            }

            $fname = $this->getFileName();
            $this->imgBehavior->deleteFile($path, $fname);
            $this->imgBehavior->saveFile($this->image, $path, $fname, $this->image->extensionName);
            //Controller::debug( $fname );
            $this->updatebyPk($this->id, array('image' => $fname.'.'.$this->image->extensionName));
        }
    }

    public function getImageUrl()
    {
        if( !empty($this->image) )
        {
            return "/uploads/users/$this->id/$this->image";
        }
        else
        {
            return false;
        }
    }

    public static function isCorrectNickName($nickname)
    {
        return (preg_match("/^[a-zA-Z0-9_-]{3,100}$/",$nickname) == 1)? true : false;
    }

    /**
     * @param $attrName
     * @param $attrContent
     * @param bool | int $user_id Must be integer or false
     * @return bool
     */
    public static function isBusyItemFieldName($attrName, $attrContent, $user_id=false)
    {
        $res = User::model()->find(array(
            'condition' => "LOWER($attrName) = :attrName",
            'params' => array(":attrName" => mb_strtolower(trim($attrContent))),
        ));
        if($res == NULL)
        {
            return false;
        }
        else
        {
            if($user_id != false)
            {
                if($res->id == $user_id)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }
    }

}
