<?php

class OrgListWidget extends CWidget
{
	public $limit = 10;
	
	public $criteria = array(
			'order' => 'created_at DESC'
	);
	
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		if ($this->limit)
			$this->criteria['limit'] = $this->limit;
		
		$os = Organization::model()->findAll($this->criteria);
		
		$this->render('orgList', array('os' => $os));
	}
	
	
}