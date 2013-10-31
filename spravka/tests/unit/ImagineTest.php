<?php

use Imagine\Image\Box;

class ImagineTest extends CTestCase
{
	public static function composer() {
		require __DIR__.'/../../../common/vendor/autoload.php';
	}
	
	public function testThumb()
	{
		self::composer();
		
		$srcFile = __DIR__.'/data/sunset.jpg';
		$trgFile = __DIR__.'/data/sunset.thumb.jpg';
		if (file_exists($trgFile)) {
			@unlink($trgFile);
		}
		
		$im = new \Imagine\Gd\Imagine();
		$img = $im->open($srcFile);
		
		$mode = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
		$img->thumbnail(new Box(50, 50), $mode)
			->save($trgFile);
		
		$this->assertTrue(file_exists($trgFile), 'file not created');
	}
}
