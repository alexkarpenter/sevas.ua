<?php

class TagLoadAction extends CAction
{
	public $modelType = 'Tag';
	public $modelAttr = 'name';
	
	public function run()
	{
		$query = Yii::app()->request->getParam('query');
		$tags = array();
		if (!empty($query))
		{
			$type = $this->modelType;
			$c = new CDbCriteria();
			$c->select = $this->modelAttr;
			$c->addSearchCondition($this->modelAttr, $query);
			$c->limit = 100;
			$tags = $type::model()->findAll($c);
		}
		
		$self = $this;
		$tags = array_map(function($t)use($self){ 
			return $t->{$self->modelAttr};
		}, $tags);
		
		echo json_encode($tags);
		Yii::app()->end();
	}
	
}