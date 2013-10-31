<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/aside';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $showTopBreadcrumbs = true;
	
    /**
     * @var string
     */
    public $activeMenu = '';

    /**
     * @var array
     */
    protected $linkMenu = array(

    );

    static public function debug()
	{
		echo '<pre>';
		var_dump(func_get_args());
		echo '</pre>';
		die();
	}

    public function successTo($msg, $url='', $params=array())
    {
        Yii::app()->user->setFlash('success', $msg);
        $this->redirect($this->createUrl($url, $params));

    }

    public function noticeTo($msg, $url='', $params=array())
    {
        Yii::app()->user->setFlash('notice', $msg);
        $this->redirect($this->createUrl($url, $params));
    }

    public function errorTo($msg, $url='', $params=array())
    {
        Yii::app()->user->setFlash('error', $msg);
        if($url!==false)
        {
            if(empty($url))
                $this->refresh();
            else
                $this->redirect($this->createUrl($url, $params));
        }
    }

    public function beforeAction($action)
    {
        if(!Yii::app()->user->isGuest)
        {
            if( User::isCorrectNickName(Yii::app()->user->name) )
            {
                return true;
            }else
            {
                if($action->id != 'profile')
                {
                    Controller::errorTo('Введите корректно свой Nickname и нажмите Редактировать', 'user/profile');
                }else
                    return true;
            }
        }else
            return true;
    }
}
