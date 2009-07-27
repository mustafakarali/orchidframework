<?php
/**
 * CREATE TABLE `cache` (
    `marker` varchar(250) character set latin1 NOT NULL,
    `content` text character set latin1,
    `valid` int(11) default NULL,
    `modified` int(11) default NULL,
    KEY `newindex` (`valid`),
    KEY `im` (`marker`)
    )  ENGINE=MyISAM
 */
include_once("interface/interface.cache.php");
class cachemysql implements cachemanager
{
	private $cachedb;
	private $cache = array();
	public function setup($cacheinfo)
	{
		if (!empty($cacheinfo)) {
			$dbname = $cacheinfo['dbname'];
			$dbhost = $cacheinfo['dbhost'];
			$dbuser = $cacheinfo['dbuser'];
			$dbpass = $cacheinfo['dbpass'];
			$dbpersistence = $cacheinfo['dbpersistence'];
			if ($dbpersistence)
			$this->cachedb  = mysql_pconnect($dbhost, $dbuser, $dbpass,true);
			else
			$this->cachedb = mysql_connect($dbhost,$dbuser,$dbpass,true);

			mysql_select_db($dbname,$this->cachedb);
		}

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

		$this->invalidate($key,true);;
		$modified = time();
		$valid = time()+$time;
		$content = serialize(array($key=>$value));
		$marker = $key;
		$query = "INSERT INTO cache (marker, content, valid, modified) values('{$marker}', '{$content}','{$valid}','{$modified}')";
		//die($query);
		//echo $qury."<br/>";
		mysql_query($query);
		$this->cache[$key]==$value;
	}


	public function isExpired($key, $time=null)
	{

		$mintime = time();
		$query = "SELECT * FROM cache WHERE marker='{$key}' AND valid>={$mintime}";
		$data = mysql_query($query,$this->cachedb);
		//echo $qury."<br/>";
		$row = mysql_fetch_assoc($data);


		if (mysql_num_rows($data)==0){
			$this->cache[$key]=="__expired__";
			return true;
		}


		if ($row['expired']=='1')
		{
			$this->cache[$key]=="__expired__";
			return true;
		}

		$_temp = unserialize($row['content']);
		$this->cache[$key] = $_temp[$key];
		return false;
	}

	public function invalidate($key, $forced=false)
	{
		$mintime = time();
		if (!$forced)
		$query = "DELETE FROM cache WHERE marker='{$key}' and valid<{$mintime} ";
		else
		$query = "DELETE FROM cache WHERE marker='{$key}'";
		
		mysql_query($query,$this->cachedb);
		unset($this->cache[$key]);
	}

}
?>