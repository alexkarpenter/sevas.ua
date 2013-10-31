<?php


class ImagerTest extends CTestCase
{
	public $source;
	
	public static function composer() {
		require __DIR__.'/../../../common/vendor/autoload.php';
	}

	protected function setUp()
	{
		$this->source =  __DIR__.'/data/sunset.jpg';
		Yii::setPathOfAlias('webroot', __DIR__);
		$this->clearCacheDir();
	}
	
	protected function tearDown()
	{
		$this->clearCacheDir();
	}
	
	private function clearCacheDir() {
		$cache = __DIR__.'/data/cache';
		if (is_dir($cache))
			exec("rm -r {$cache}");
		//unlink($cache);
	}
	
	
	public function testImager()
	{
		$imager = new Imager();
		
		$imager->presets = array(
				'thumb50x50' => array(
						'targetDirAlias' => 'application.tests',
						'targetTemplate' => '/unit/data/cache/thumb.{$self->sourceInfo["basename"]}',
						'actions' => array(
								array('thumbnail', array(50, 50, 'outbound')),
						) 
				)
		);
		
		$source = __DIR__.'/data/sunset.jpg';
		$targetExp = __DIR__.'/data/cache/thumb.sunset.jpg';
		
		$target = $imager->getImagePath($source, 'thumb50x50');
		
		$this->assertEquals($targetExp, $target);
	}

	public function testImagerChain()
	{
		$imager = new Imager();
	
		$watermark = __DIR__.'/data/3star.png';
		
		$imager->presets = array(
				'chain' => array(
						'targetDirAlias' => 'application.tests',
						'targetTemplate' => '/unit/data/cache/chain.{$self->sourceInfo["basename"]}',
						'actions' => array(
								array('resize', array(150, 150)),
								array('watermark', array($watermark, array('bottom' => 10, 'right' => 10))),
						)
				)
		);
	
		$source = __DIR__.'/data/sunset.jpg';
		$targetExp = __DIR__.'/data/cache/chain.sunset.jpg';
		$targetUrlExp = '/data/cache/chain.sunset.jpg';
		
		$target = $imager->getImagePath($source, 'chain');
		$targetUrl = $imager->getImageUrl($source, 'chain');
		
		$this->assertEquals($targetExp, $target);
		$this->assertEquals($targetUrlExp, $targetUrl);
	}
	
	
	public function testImagerErrors()
	{
		$imager = new Imager();
	
		$imager->presets = array(
				'normalize' => array(
						'targetDirAlias' => 'application.tests',
						'targetTemplate' => '/unit/data/cache/{$self->sourceInfo["basename"]}',
						'actions' => array(
								array('nosuchAction', array(150, 150)),
						)
				)
		);

		$target = $imager->getImagePath($this->source, 'preset_notexists');
		$this->assertFalse($target);

		$target = $imager->getImagePath(__DIR__.'/data/notexists.jpg', 'normalize');
		$this->assertFalse($target);
		
		$target = $imager->getImagePath($this->source, 'normalize');
		$this->assertFalse($target);
		
		$imager->errorImagePath = __DIR__.'/data/error.gif';
		$imager->init();
		$target = $imager->getImagePath(__DIR__.'/data/notexists.jpg', 'normalize');
		$this->assertEquals($imager->errorImagePath, $target);
	}
	
}
