<?php
class NewsRatingEnum{
	const RATING_UP = 0;
	const RATING_DOWN = 1;
	
	static public $list = array(
		self::RATING_UP => 'голос за',
		self::RATING_DOWN => 'голос против',
	);
}
?>
