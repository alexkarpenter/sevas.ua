<?php
/**
 * 
 * статистика справочника
 *
 */
class OrgStatWidget extends CWidget
{
	public $cacheTime = 600;
	
	public $orgCount;
	
	public $orgCountLastMonth;
	
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$this->orgCount = Organization::model()->cache($this->cacheTime)->count();
		
		$condition = "t.created_at > date_sub(now(), interval '1' month)";
		$this->orgCountLastMonth = Organization::model()->cache($this->cacheTime)->count($condition);
		
		$this->render('orgStat', array());
	}
	
	
}