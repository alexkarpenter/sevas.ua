<?php

class Category extends BaseActiveRecord
{
	public static function model($className=__CLASS__){
        return parent::model($className);
    }
 
    public function tableName(){
        return Yii::app()->params['kriminal_db'].'.category';
    }
	
	public static function getAllCategory()
	{
		$model=Category::model()->findAll(array(
			'select' => 'name, id'
		));
		
		$cat = array();
		foreach($model as $item)
		{
			$cat[$item->id] = $item->name;
			//array_push($cat, $item->id => $item->name);
		}
		
		return $cat;
	}
}

?>
