<?
include_once("interface/interface.cache.php");
class cachemysql implements cachemanager
{
	private $cachedb;
	private $cache = array();
	public function setup($cacheinfo)
	{
		base::pr($cacheinfo);
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

		$modified = time();
		$valid = time()+$time;
		$content = serialize(array($key=>$value));
		$marker = $key;
		$query = "REPLACE INTO cache (marker, content, valid, modified) values('{$marker}', '{$content}','{$valid}','{$modified}')";
		mysql_query($query);
		$this->cache[$key]==$value;
	}


	public function isExpired($key, $time=null)
	{

		$mintime = time();
		$data = mysql_query("SELECT * FROM cache WHERE marker='{$key}' AND valid>={$mintime}",$this->cachedb);

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