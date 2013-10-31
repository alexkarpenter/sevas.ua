<?php

class MapWidget extends CWidget
{
	public $ymapsPackage = 'package.standard';
	public $width = 320;
	public $height = 240;
	public $center = array(44.616649, 33.52536); // lat, lon
	public $address; // for geocode
	public $balloon;
	public $boundedBy = array(array(44.443595,33.309753), array(44.847511,33.900268)); // sw, ne;
	public $zoom = 11;
	public $onready;
	public $scriptParams;
	
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$this->render('map');
	}
	
	
}