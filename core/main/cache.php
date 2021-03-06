<?php
/**
 * The cache manager for orchid. It works seamlessly with memcache, sqlite and
 * mysql as cache storage
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
include_once("cache/interface/interface.cache.php");
class cache 
{
	private $cacheengine;
	
	public function __construct()
	{
		$config = loader::load("config");
		$cacheengine = $config->cache_source;
		if (!empty($cacheengine))
		{
			//retrieve the cache settings
			$key = "cache_{$cacheengine}";
			$cacheinfo = $config->$key;
			//base::pr($cacheinfo);
			$cacheobject = "cache{$cacheengine}";
			$this->cacheengine = new $cacheobject();
			$this->cacheengine->setup($cacheinfo);
		}
		else 
		throw  new Exception("Please provide cache engine details in configuration file");
	}
	
	public function set($key, $content, $time = 86400)
	{
		$this->cacheengine->set($key, $content, $time);
	}
	
	public function get($key)
	{
	 	return  $this->cacheengine->get($key);
	}
	
	public function isExpired($key)
	{
	 	return  $this->cacheengine->isExpired($key);
	}
	
	public function invalidate($key, $forced=false)
	{
	 	return  $this->cacheengine->invalidate($key, $forced);
	}
	
	public function delete($key)
	{
		$this->invalidate($key,true);
	}
}
?>