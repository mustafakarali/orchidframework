<?php
include_once("interface/interface.cache.php");
class CacheMemcache implements cachemanager
{
	private $memcached;
	public function __construct()
	{
		$this->memcached = new Memcache();
	}
	public function setup($cacheinfo){
		$servers = $cacheinfo['servers'];
		foreach ($servers as $server)
		{
			$this->memcached->addServer($server['host'], $server['port']);
		}
	}
	public function get($key){
		if (!empty($key))
		return $this->memcached->get($key);
		return false;

	}
	public function set($key, $value, $time=86400){
		if (!empty($key) && !empty($value)){
			$this->memcached->set($key,$value,null,$time);
			return true;
		}
		return false;
	}
	public function isExpired($key){
		$val = $this->get($key);
		if (empty($val)) return true;
		return false;
	}
	public function invalidate($key, $forced=false){
		if (!empty($key)){
			$this->memcached->delete($key);
			return true;
		}
		return false;
	}
}
?>