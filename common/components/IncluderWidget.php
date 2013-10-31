<?php
/**
 * 
 * Включение файла с параметрами
 *
 */
class IncluderWidget extends CWidget
{
	public $view;
	
	public $params;
	
	public function run()
	{
		$view = $this->view;
		if (strpos($view, '.') === false)
			$view = 'common.views.include.'.$view;
		
		$this->render($view, $this->params);
	}
}