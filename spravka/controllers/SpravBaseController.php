<?php

class SpravBaseController extends Controller
{
	public $showTopBreadcrumbs = false;
	
	public $layout='spravka.views.layouts.spravka-aside';

	public $pageHeading = 'Справочник Севастополя'; 
	
	public $pageH1 = 'Справочник Севастополя';
	
	public $breadcrumbs = array();
	
	public function addBreadcrumbs($bs) {
		$this->breadcrumbs = array_merge($this->breadcrumbs, $bs);
	}
	
	public function printH1() {
		print '<h1>'.CHtml::encode($this->pageH1).'</h1>';
	}
	
	private $_pageTitle;
	
	public function getPageTitle()
	{
		if (isset($this->_pageTitle))
			return $this->_pageTitle;
		return $this->pageH1;
	}
	
	public function setPageTitle($v)
	{
		$this->_pageTitle = $v;
	}
	
}