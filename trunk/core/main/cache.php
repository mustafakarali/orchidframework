<?
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
	}
	
	public function set($key, $content, $extra = null)
	{
		$this->cacheengine->set($key, $content, $extra);
	}
	
	public function get($key)
	{
	 	return  $this->cacheengine->get($key);
	}
	
	public function isExpired($key, $time=null)
	{
	 	return  $this->cacheengine->isExpired($key, $time);
	}
	
	public function invalidate($key)
	{
	 	return  $this->cacheengine->invalidate($key);
	}
}
?>