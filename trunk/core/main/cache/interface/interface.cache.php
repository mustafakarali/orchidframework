<?
interface cachemanager
{
	public function setup($cacheinfo);
	public function get($key);
	public function set($key, $value, $time=86400);
	public function isExpired($key);
	public function invalidate($key, $forced=false);
}
?>