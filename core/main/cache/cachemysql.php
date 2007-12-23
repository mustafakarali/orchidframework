<?
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
		if (isset($this->cache[$key]))
		return $this->cache[$key];
		else
		return array();
	}

	public function set($key, $value, $extra = null)
	{

		$modified = time();
		$content = serialize($value);
		$marker = $key;

		$data = mysql_query("select * from cache where marker='{$key}'",$this->cachedb);

		if (mysql_num_rows($data)==0)
		{
			//insert new row
			$query = "INSERT INTO cache (id, marker, content, extra, modified) values(null, '{$marker}', '{$content}','{$extra}','{$modified}')";
		}
		else
		{
			//update
			if (!empty($extra))
			$query = "UPDATE cache set content='{$content}', extra ='{$extra}', modified = '{$modified}', expired=1 WHERE marker='{$marker}'";
			else
			$query = "UPDATE cache set content='{$content}', modified = '{$modified}', expired=1 WHERE marker='{$marker}'";
		}

		//die($query);
		mysql_query($query, $this->cachedb);
	}


	public function isExpired($key, $time=null)
	{
		if (!empty($time)){
			$mintime = time()-$time;
			$data = mysql_query("SELECT * FROM cache WHERE marker='{$key}' AND modifed>={$mintime}",$this->cachedb);
		}
		else
		$data = mysql_query("SELECT * FROM cache WHERE marker='{$key}'",$this->cachedb);
		$row = mysql_fetch_assoc($data);
		
		
		if (mysql_num_rows($data)==0){
			$this->cache[$key]==array();
			return true;
		}
		

		if ($row['expired']=='0')
		{
			$this->cache[$key]==array();;
			return true;
		}
		
		
		
		//die(print_r(unserialize($row['content'])));
		
		$this->cache[$key]=unserialize($row['content']);
		//die($this->cache[$key]);
		return false;
	}
	
	public function invalidate($key)
	{
		$query = "UPDATE cache SET expired=0 WHERE marker='{$key}'";
		mysql_query($query,$this->cachedb);
		unset($this->cache[$key]);
	}

}
?>