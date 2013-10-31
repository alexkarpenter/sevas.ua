<?php
class UserController extends Controller
{
    public function actionLogin()
    {
        // if it is ajax validation request
        if( Yii::app()->request->isAjaxRequest )
        {
            $model = new User();
            $model->password = $_POST['pass'];
            $model->email = $_POST['email'];

            User::model()->updateAll(array('last_visit_date' => time()),
                array(
                    'condition' => 'email = :email',
                    'params'    => array(':email' => $model->email),
                )
            );

            if($model->login())
            {
                echo json_encode(array('hasError' => '0', 'username' => Yii::app()->user->name));
            }
            else
            {
                echo json_encode(array('hasError' => '1'));
            }
            Yii::app()->end();
        }
    }

    public function actionReg()
    {
        if( Yii::app()->request->isAjaxRequest )
        {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];

            $gen_code = '';
            for($i=0; $i<15; $i++) {
                $gen_code.= chr(rand(65,90));
            }


            $transaction=Yii::app()->db->beginTransaction();
            //$transaction=$user->dbConnection->beginTransaction();
            try
            {
                $user = new User('register');
                $user->nickname = $nickname;
                $user->password = $password;
                $user->password_repeat = $password_repeat;
                $user->email = $email;
                $user->state = UserStateEnum::WAITING_REG;
                $user->once_pass = $gen_code;
                $user->register_date = time();
                if(!$user->save())
                {
                    echo json_encode( array('hasError' => $user->getErrors()) );
                    $transaction->rollback();
                    Yii::app()->end();
                }
                $link_finish_reg = $this->createUrl(Yii::app()->request->getBaseUrl(true).'/user/activation', array('code'=>$gen_code));
                $mail = new YiiMailer();
                $mail->setView('confirmEmail');
                $mail->setFrom('info@'.Yii::app()->params['appId'].'.sevas.ua');
                $mail->setTo($user->email);
                $mail->setSubject('Подтверждение адреса электронной почты');
                $mail->setData(array('message' => $link_finish_reg));

                /*$mail->ContentType = 'text/html';
                $mail->IsHTML(true);*/

                if($mail->send())
                {
                    echo CJSON::encode(array('success_send' => '1'));
                    $transaction->commit();
                }
                else
                {
                    echo CJSON::encode(array('success_send' => '0'));
                    $transaction->rollback();
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
            Yii::app()->end();
        }
    }

    public function actionActivation()
    {
        if(isset($_GET['code']))
        {
            $user = User::model()->find(array(
                'condition' => 'once_pass=:code AND state=:state',
                'params' => array(
                    ':code' => $_GET['code'],
                    ':state' => UserStateEnum::WAITING_REG
                )
            ));

            if(!$user)
            {
                Yii::app()->user->setFlash('error',"Код подтверждения не найден!");
                $this->redirect( Yii::app()->createUrl('news/index') );
            }

            $user->once_pass = 'NULL';
            $user->state = UserStateEnum::USER_ACTIVE;
            $user->save();

            Yii::app()->user->setFlash('success', $user->nickname.", вы зарегистрированы!");
            $this->redirect( Yii::app()->createUrl('news/index') );
        }
        else
        {
            Yii::app()->user->setFlash('error',"Не указан код подтверждения!");
            $this->redirect( Yii::app()->createUrl('news/index') );
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionList()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_POST['User'])){
            $model->attributes=$_POST['User'];
            $model->name = $_POST['User']['name'];
            $model->state = $_POST['User']['state'];
            $model->email = $_POST['User']['email'];
            $model->register_date = strtotime( date('Y-m-d', strtotime($_POST['User']['register_date'])) );
            $model->last_visit_date = strtotime( date('Y-m-d', strtotime($_POST['User']['last_visit_date'])) );
        }

        $this->render('common.views.user.list_edit', array(
            'model'=>$model,
        ));
    }

    /**
     * @param User $model
     * @return string
     */
    public static function getStateRButtons($model)
    {
        $str = '';
        if($model->state == UserStateEnum::WAITING_REG)
        {
            $str = 'Ожидает подтверждения';
        }
        elseif($model->state == UserStateEnum::USER_ACTIVE)
        {
            $str = CHtml::radioButton($model->id, false, array('class' => 'state_radiobtn', 'value' => UserStateEnum::USER_BLOCKED));
            $str .= CHtml::radioButton($model->id, true, array('class' => 'state_radiobtn', 'value' => UserStateEnum::USER_ACTIVE));
            $str .= '<span class="msg_succ_'.$model->id.'" style="color:green">Активен</span>';
        }
        elseif($model->state == UserStateEnum::USER_BLOCKED)
        {
            $str = CHtml::radioButton($model->id, true, array('class' => 'state_radiobtn', 'value' => UserStateEnum::USER_BLOCKED));
            $str .= CHtml::radioButton($model->id, false, array('class' => 'state_radiobtn', 'value' => UserStateEnum::USER_ACTIVE));
            $str .= '<span class="msg_succ_'.$model->id.'" style="color:red">Заблокирован</span>';
        }

        return $str;
    }

    //Switch state in user list
    public function actionSwitchState()
    {
        if( Yii::app()->request->isAjaxRequest )
        {
            $user_id = $_POST['user_id'];
            $state = $_POST['state'];
            if(User::model()->updateByPk($user_id, array('state'=>$state)))
            {
                echo json_encode(array('switch_succ'=>'1'));
            }
            else
            {
                echo json_encode(array('switch_succ'=>'0'));
            }
        }
    }

    public function actionProfile()
    {
        if(!Yii::app()->user->checkAccess('updateOwnUser'))
            throw new CHttpException(403, 'Доступ только для авторизованных пользователей');

        $transaction=Yii::app()->db->beginTransaction();
        try{
            $state_trans = true;

            $user_id = Yii::app()->user->id;
            $modelUser = User::model()->findbyPk($user_id);
            $modelUser->scenario = 'profile';

            if(!$model = UserProfile::model()->find(array(
                    'condition' => 'user_id = :user_id',
                    'params' => array(':user_id' => $user_id),
                )
            ))
            {
                $model = new UserProfile();
            }

            if(isset($_POST['User']))
            {
                //$modelUser->attributes = $_POST['User'];
                if( isset($_POST['User']['nickname'] ))
                {
                    $modelUser->nickname = $_POST['User']['nickname'];
                    $newNickName = $modelUser->nickname;
                }
                if(CUploadedFile::getInstance($modelUser, 'image') != NULL)
                {
                    $modelUser->image = CUploadedFile::getInstance($modelUser, 'image');
                }

                $state_trans = $modelUser->save() && $state_trans;
            }

            if(isset($_POST['UserProfile']))
            {
                if($model = UserProfile::model()->find(array(
                        'condition' => 'user_id = :user_id',
                        'params' => array(':user_id' => $user_id),
                    )
                ))
                {
                    //update model
                    $model->attributes = $_POST['UserProfile'];
                    //return false or datetimestamp
                    $birthday = UserProfile::birthDayToInt($_POST['UserProfile']['listdate'], $_POST['UserProfile']['listmonth'], $_POST['UserProfile']['listyear']);
                    ($birthday) ? $model->birthday = $birthday : '';

                    $model->save();
                }
                else
                {
                    //new model
                    $model = new UserProfile();
                    $model->attributes = $_POST['UserProfile'];
                    $model->user_id = $user_id;
                    //return false or datetimestamp
                    $birthday = UserProfile::birthDayToInt($_POST['UserProfile']['listdate'], $_POST['UserProfile']['listmonth'], $_POST['UserProfile']['listyear']);
                    ($birthday) ? $model->birthday = $birthday : '';
                    $model->save();
                    $state_trans = $model->save() && $state_trans;
                }
            }
            if($state_trans == true)
            {
                //if uset set new nickname
                if(isset($newNickName))
                {
                    Yii::app()->user->name = $newNickName;
                }
                $transaction->commit();
            }else
            {
                $transaction->rollback();
                Controller::errorTo('Не удалось сохранить ваш профайл', 'user/profile');
            }

        }catch(Exception $e)
        {
            $transaction->rollback();
        }

        $this->render('common.themes.'.Yii::app()->theme->name.'.views.user.profile', array('model' => $model,
            'modelUser' => $modelUser));
    }

    public function actionCorrectNickName()
    {
        if( Yii::app()->request->isAjaxRequest )
        {
            $nickname = $_POST['nickname'];
            echo (User::isCorrectNickName($nickname) == true) ? json_encode(array('isCorrectNickName' => '1')) : json_encode(array('isCorrectNickName' => '0'));
            Yii::app()->end();
        }
    }

    public function actionBusyItemName()
    {
        if( Yii::app()->request->isAjaxRequest )
        {
            $fieldName = $_POST['fieldName'];
            $fieldContent = $_POST['fieldContent'];
            echo (User::isBusyItemFieldName($fieldName, $fieldContent) == true) ? json_encode(array('isbusy' => '1')) : json_encode(array('isbusy' => '0'));
            Yii::app()->end();
        }
    }

}