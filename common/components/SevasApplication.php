<?php

class SevasApplication extends CWebApplication
{

	/**
	 * project top level domain
	 * @var string
	 */
	public $host;
	
	/**
	 * common subdomain name
	 * @var string
	 */
	public $commonHost;

	/**
	 * creates absolute url to subdomain resource
	 * @param string $route
	 * @param array $params
	 * @param string $subdomainName
	 * @return string
	 */
	public function createSubUrl($route, $params=array(), $subdomainName='common')
	{
		$url = parent::createUrl($route, $params);
		return "http://{$subdomainName}.{$this->host}".($url[0] == '/' ? '' : '/').$url;
	}
	
	/**
	 * gives absolute subdomain url from array like CHtml::normalizeUrl 
	 * @param mixed $url
	 * @param string $subdomainName
	 */
	public function subUrl($url, $subdomainName='common')
	{
		if(is_array($url))
		{
			if(isset($url[0]))
			{
				return $this->createSubUrl($url[0],array_splice($url,1));
			}
			else
				$url='';
		}
		return "http://{$subdomainName}.{$this->host}".($url[0] == '/' ? '' : '/').$url;
	}
	
	
}