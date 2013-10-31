<?php

/**
 * 
 * Все ресурсы грузятся с одного домена (common)
 * @author pavl
 *
 */
class SClientScript extends CClientScript
{
	public function getCommonHost() {
		return Yii::app()->commonHost;
	}
	
	public function render(&$output)
	{
		return parent::render($output);
	}
	
	public function renderCoreScripts()
	{
		parent::renderCoreScripts();
	}
	
	public function renderHead(&$output)
	{
		$this->cssFiles = $this->urlArrayConvert($this->cssFiles);
		if($this->enableJavaScript)
		{
			if(isset($this->scriptFiles[self::POS_HEAD]))
			{
				$this->scriptFiles[self::POS_HEAD] = $this->urlArrayConvert( $this->scriptFiles[self::POS_HEAD] );
			}
		
		}
		
		parent::renderHead($output);
	}

	public function renderBodyBegin(&$output)
	{
		if(isset($this->scriptFiles[self::POS_BEGIN]))
		{
			$this->scriptFiles[self::POS_BEGIN] = $this->urlArrayConvert( $this->scriptFiles[self::POS_BEGIN] );
		}
		parent::renderBodyBegin($output);
	}
	
	public function renderBodyEnd(&$output)
	{
		if(isset($this->scriptFiles[self::POS_END]))
		{
			$this->scriptFiles[self::POS_END] = $this->urlArrayConvert( $this->scriptFiles[self::POS_END] );
		}
		parent::renderBodyEnd($output);
	}
	
	public function urlArrayConvert($urlsIn)
	{
		$host = $this->getCommonHost();
		$urls = array();
		foreach ($urlsIn as $url => $value) {
			if (!preg_match('#^(?:http|//)#', $url)) {
				$url = "http://{$host}{$url}";
			}
			$urls[$url] = $value; 
		}
		return $urls;
	}
}