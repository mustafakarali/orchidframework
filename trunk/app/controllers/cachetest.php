<?
class cachetest extends controller
{
	function base()
	{
		$this->use_view=false;
		$cache = loader::load("cache");
		
		$cache->set("abcd","Hello World",2);
		$cache->set("abcd2","Hello World2",5);
		sleep(3);
		
		if ($cache->isExpired("abcd"))
		echo "This key has been expired after 2 seconds";
		
		echo $cache->get("abcd").":".$cache->get("abcd2");
		

	}
}
?>