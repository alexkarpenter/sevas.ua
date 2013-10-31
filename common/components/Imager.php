<?php

use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;

/**
 * 
 * обработчик изображений
 *
 */
class Imager extends CComponent
{
	protected $presetName;

	public $source;
	
	public $sourceInfo;
	
	public $preset;
	
	public $params;

	public $target;
	
	public $targetDir;
	
	public $errorImagePath;
	
	public $errorImageUrl;
	
	/**
	 * @var \Imagine\Image\ImagineInterface
	 */
	public $imagine;
	
	/**
	 * 
	 * @var \Imagine\Image\ImageInterface
	 */
	public $img;
	
	public $presets = array(
		'thumb50x50' => array(
				'targetDirAlias' => 'webroot.upload.cache.thumb50x50',
				'targetTemplate' => '/{$self->getHashSubdir($self->source)}/{$self->sourceInfo["basename"]}',
				'actions' => array(
						array('thumbnail', array(50, 50, 'outbound')),
				) 
		)
	);

	public $reTemplateString = '#\{(?=\$)([^\}]+)\}#';
	
	public function init() {
		$webroot = Yii::getPathOfAlias('webroot');
		if ($this->errorImagePath)
			$this->errorImageUrl = substr($this->errorImagePath, strlen($webroot));
		elseif ($this->errorImageUrl)
			$this->errorImagePath = $webroot.$this->errorImageUrl;
	}

	/**
	 * Обработка изображения $source, если еще не обработано
	 * @param string $source image path
	 * @param string $preset
	 * @param array $params
	 * @return string
	 */
	public function getImageUrl($source, $preset, $params=array())
	{
		$targetPath = $this->getImagePath($source, $preset, $params);
		$webroot = Yii::getPathOfAlias('webroot');
		$targetUrl = substr($targetPath, strlen($webroot));
		return $targetUrl;
	}
	
	public function getImagePath($source, $preset, $params=array())
	{
		$targetPath = false;
		try {

			if (!file_exists($source))
				throw new Exception('source not exists');

			$this->source = $source;
			$this->preset = $preset;
			$this->params = $params;
			$this->sourceInfo = pathinfo($source);

			if (!$preset = @$this->presets[$preset])
				throw new Exception('wrong preset');
			$self = $this;
			$targetDir = Yii::getPathOfAlias($preset['targetDirAlias']);
			$target = preg_replace_callback( $this->reTemplateString, function($ms)use($self){
				return eval('return '.$ms[1].';');
			}, $preset['targetTemplate'] );
			$targetPath = $targetDir.$target;
			$this->target = $targetPath;
			
			if (file_exists($targetPath)) // уже обработана
				return $targetPath;
			
			$this->performActions();
			
			$dir = dirname($targetPath);
			if (!file_exists($dir))
				mkdir($dir, 0777, true);
			
			$this->img->save($targetPath);
				
		} catch (Exception $e) {
			Yii::log($e->getMessage(), 'error', get_class($this));
		}
		
		if (!file_exists($targetPath))
			$targetPath = false;
		
		return $targetPath ?: $this->errorImagePath ?: false;
	}
	
	/**
	 * для раскладывания обработанных файлов по подкаталогам 
	 */
	public function getHashSubdir($source)
	{
		return crc32($source) % 100;
	}
	
	/**
	 * @return \Imagine\Image\ImageInterface
	 */
	public function performActions()
	{
		Utils::composer();
		
		$imagine = $this->imagine = $this->imagine ?: new \Imagine\Gd\Imagine();
		$this->img = $imagine->open($this->source);
		
		$preset = $this->presets[$this->preset];
		
		foreach ($preset['actions'] as $action) {
			list($name, $params) = $action;
			$img = call_user_func_array(array($this, 'action'.$name), $params);
		}
		
	}

	public function actionThumbnail($width, $height, $mode)
	{
		$this->img = $this->img->thumbnail(new Box($width, $height), $mode);
		return true;
	}

	public function actionResize($width, $height)
	{
		$this->img->resize(new Box($width, $height));
		return true;
	}

	/**
	 * @param string $watermarkPath
	 * @param array $anchor
	 * @return boolean
	 */
	public function actionWatermark($watermarkPath, $anchor)
	{
		$watermark = $this->imagine->open($watermarkPath);
		$wsize = $watermark->getSize();
		$size = $this->img->getSize();
		$x = @$anchor['left'] ?:
			$size->getWidth() - $wsize->getWidth() - @$anchor['right'];
		$y = @$anchor['top'] ?:
			$size->getHeight() - $wsize->getHeight() - @$anchor['bottom'];
		
		$this->img->paste($watermark, new Point($x, $y));
		return true;
	}
	
}