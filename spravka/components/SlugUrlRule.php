<?php
/**
 * 
 * SlugUrlRule - форматирование маршрутов с ЧПУ без эскейпинга
 * createUrl('sprav/category', 'slug' => 'transport/auto') => 'category/transport/auto'
 *
 */
class SlugUrlRule extends CBaseUrlRule
{
	public $routes = array(
		'sprav/org' => 'org',
		'sprav/category' => 'category',
	);
	
	public function init()
	{
	}
	
	public function createUrl($manager,$route,$params,$ampersand)
	{
		if (!isset($this->routes[$route]) || !isset($params['slug']))
			return false;
		
		$prefix = $this->routes[$route];
		$url = $prefix.'/'.$params['slug'];
		
		unset($params['slug']);
		
		if(empty($params))
			return $url;
		
		//$url.='/'.$manager->createPathInfo($params,'/','/');
		$url .= '?'.$manager->createPathInfo($params,'=',$ampersand);
		
		return $url;
	}
	
	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		$prefixes = array_flip($this->routes);
		foreach ($prefixes as $prefix => $route) {
			if (strncmp($pathInfo, $prefix, strlen($prefix)) === 0) {
				$slug = substr($pathInfo, strlen($prefix)+1);
				$_GET['slug'] = $slug;
				return $route;
			}
		}
		return false;
	}
	
}