<?
interface cachemanager
{
	public function setup($cacheinfo);
	public function get($key);
	public function set($key, $value, $extra=null);
	public function isExpired($key, $time=null);
	public function invalidate($key);
}
?>