<?
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
			sqlite_exec("create table cache ( id INTEGER AUTOINCREAMENT PRIMARY KEY, marker VARCHAR UNIQUE, content TEXT, extra VARCHAR, modified INT, expired INTEGER DEFAULT 0)  ",$this->cachedb);
			sqlite_exec("create index marker on cache (marker)  ",$this->cachedb);
		}
		else
		$this->cachedb = sqlite_open($this->cachefile,0666);
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

		$data = sqlite_query("select * from cache where marker='{$key}'",$this->cachedb);

		if (sqlite_num_rows($data)==0)
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
		sqlite_query($query, $this->cachedb);
	}


	public function isExpired($key, $time=null)
	{
		if (!empty($time)){
			$mintime = time()-$time;
			$data = sqlite_query("SELECT * FROM cache WHERE marker='{$key}' AND modifed>={$mintime}",$this->cachedb);
		}
		else
		$data = sqlite_query("SELECT * FROM cache WHERE marker='{$key}'",$this->cachedb);
		$row = sqlite_fetch_array($data,SQLITE_ASSOC);
		
		
		if (sqlite_num_rows($data)==0){
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
		$query = "UPDATE cache SET content='', expired=0 WHERE marker='{$key}'";
		sqlite_query($query,$this->cachedb);
		unset($this->cache[$key]);
	}

}
?>