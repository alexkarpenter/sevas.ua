<?php
class ChangesPerDay extends CWidget
{

    public function run()
    {

        $changesperday_model = News::model()->count(array(
            'select' => 'id',
            'condition' => "create_date>=UNIX_TIMESTAMP(CURDATE()) AND status='0'", //right
        ));

        $countofreg = User::model()->count(array(
            'select' => 'id',
            'condition' => 'register_date>=UNIX_TIMESTAMP(CURDATE())', //right
        ));
        $this->render('common.widgets.changesperday.view.changesperday', array(
            'changesperday_model' => $changesperday_model,
            'countofreg' => $countofreg));
    }

}

?>