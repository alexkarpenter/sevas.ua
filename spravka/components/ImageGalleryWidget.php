<?php

class ImageGalleryWidget extends CWidget
{
	/**
	 * @var File[]
	 */
	public $files;
	
	public $view = 'imageGallery';
	
	public function run()
	{
		$this->render($this->view, array());
	}
	
}