<?php
include_once("interface/interface.cache.php");
class cachesqlite implements cachemanager
{
	private $cachebase;
	private $cachefile = "cache.sq2";
	private $cachedb;
	private $cache = array();
	public function setup($cacheinfo)
	{
		//check if the db has been setup
		$this->cachebase ="app/cache/";
		if (!empty($cacheinfo)) {
			$this->cachefile = $cacheinfo['dbname'];
		}

		$this->cachefile = $this->cachebase.$this->cachefile;

		if (!file_exists($this->cachefile))
		{
			$this->cachedb = sqlite_open($this->cachefile,0666);
			sqlite_exec("create table cache ( marker VARCHAR PRIMARY KEY, content TEXT, modified INT, valid INT, expired INTEGER DEFAULT 0)  ",$this->cachedb);
			//sqlite_exec("create index marker on cache (marker)  ",$this->cachedb);
		}
		else
		$this->cachedb = sqlite_open($this->cachefile,0666);
	}


	public function get($key)
	{

		if (!$this->isExpired($key))
		return $this->cache[$key];
			else 
		$this->invalidate($key);
		return "";
	}

	public function set($key, $value, $time=86400)
	{

		$modified = time();
		$valid = time()+$time;
		$content = serialize(array($key=>$value));
		$marker = $key;
		$query = "REPLACE INTO cache (marker, content, valid, modified) values('{$marker}', '{$content}','{$valid}','{$modified}')";
		sqlite_query($query, $this->cachedb);
		$this->cache[$key]==$value;
	}


	public function isExpired($key)
	{
		$mintime = time();
		$data = sqlite_query("SELECT * FROM cache WHERE marker='{$key}' AND valid>={$mintime}",$this->cachedb);

		$row = sqlite_fetch_array($data,SQLITE_ASSOC);


		if (sqlite_num_rows($data)==0){
			$this->cache[$key]=="__expired__";
			return true;
		}


		if ($row['expired']=='1')
		{
			$this->cache[$key]=="__expired__";
			return true;
		}



		//die(print_r(unserialize($row['content'])));

		$_temp = unserialize($row['content']);
		$this->cache[$key] = $_temp[$key];
		//die($this->cache[$key]);
		return false;
	}

	public function invalidate($key, $forced=false)
	{
		$mintime = time();
		if (!$forced)
		$query = "DELETE FROM cache WHERE marker='{$key}' and valid<{$mintime} ";
		else
		$query = "DELETE FROM cache WHERE marker='{$key}'";


		sqlite_query($query,$this->cachedb);
		unset($this->cache[$key]);
	}

}
?>