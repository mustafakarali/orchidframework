<?
class mssqldriver extends abstractdbdriver 
{

	public function __construct($dbinfo)
	{
		if (!empty($dbinfo['dbname']))
		{
			if ($dbinfo['persistent'])
			$this->connection = mssql_pconnect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpwd']);
			else
			$this->connection = mssql_connect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpwd']);
			mssql_select_db($dbinfo['dbname'],$this->connection);
		}
		else
		throw new Exception("You must supply username, password, hostname and database name for connecting to mssql");
	}

	public function execute($sql)
	{
		$sql = $this->prepQuery($sql);
		$parts = split(" ",trim($sql));
		$type = strtolower($parts[0]);
		$hash = md5($sql);
		$this->lasthash = $hash;

		if ("select"==$type)
		{
			if (isset($this->results[$hash]))
			{
				if (is_resource($this->results[$hash]))
				return $this->results[$hash];
			}
		}
		else if("update"==$type || "delete"==$type)
		{
			$this->results = array(); //clear the result cache
		}
		$this->results[$hash] = mssql_query($sql,$this->connection);


	}

	public function count()
	{
		//print_r($this);
		$lastresult = $this->results[$this->lasthash];
		//print_r($this->results);
		$count = mssql_num_rows($lastresult);
		if (!$count) $count = 0;
		return $count;
	}


	private  function prepQuery($sql)
	{
		// "DELETE FROM TABLE" returns 0 affected rows This hack modifies
		// the query so that it returns the number of affected rows
		if (preg_match('/^\s*DELETE\s+FROM\s+(\S+)\s*$/i', $sql))
		{
			$sql = preg_replace("/^\s*DELETE\s+FROM\s+(\S+)\s*$/", "DELETE FROM \\1 WHERE 1=1", $sql);
		}


		return $sql;
	}

	public function escape($sql)
	{
		return str_replace("'", "''", $sql);
	}

	
	public function affectedRows()
	{
		return @mssql_affected_rows($this->connection);
	}

	public function insertId()
	{
		$_temp - $this->lasthash;
		$this->execute("SELECT @@VERSION AS ver");
		$row = $this->getRow();
		$version = $row['ver'];
		$ver = $this->_parse_major_version($version);
		$sql = ($ver >= 8 ? "SELECT SCOPE_IDENTITY() AS last_id" : "SELECT @@IDENTITY AS last_id");
		$this->execute($sql);
		$row = $this->getRow();
		$this->lasthash =$_temp; //for editing next
		return $row['last_id'];
	}


	public function transBegin()
	{
		$this->execute('SET AUTOCOMMIT=0');
		$this->execute('START TRANSACTION'); // can also be BEGIN or BEGIN WORK
		return TRUE;
	}

	public function transCommit()
	{
		$this->execute('COMMIT');
		$this->execute('SET AUTOCOMMIT=1');
		return TRUE;
	}


	public function transRollback()
	{
		$this->execute('ROLLBACK');
		$this->execute('SET AUTOCOMMIT=1');
		return TRUE;
	}
	
	
	
	public function getRow($fetchmode = FETCH_ASSOC)
	{
		
		$lastresult = $this->results[$this->lasthash];
		if (FETCH_ASSOC == $fetchmode)
		$row = mssql_fetch_row($lastresult);
		elseif (FETCH_ROW == $fetchmode)
		$row = mssql_fetch_row($lastresult);
		elseif (FETCH_OBJECT == $fetchmode)
		$row = mssql_fetch_object($lastresult);
		else
		$row = mssql_fetch_array($lastresult, MSSQL_BOTH);
		return $row;
	}
	
	public function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
	{
		$lastresult = $this->results[$this->lasthash];
		if (!empty($offset))
		{
			mssql_data_seek($lastresult, $offset);
		}
		return $this->getRow($fetchmode);
	}
	
	public function rewind()
	{
		$lastresult = $this->results[$this->lasthash];
		mssql_data_seek($lastresult, 0);
	}
	
	public function getRows($start, $count, $fetchmode = FETCH_ASSOC)
	{
		$lastresult = $this->results[$this->lasthash];
		mssql_data_seek($lastresult, $start);
		$rows = array();
		for ($i=$start; $i<=($start+$count); $i++)
		{
			$rows[] = $this->getRow($fetchmode);
		}
		return $rows;
	}
	
	function __destruct(){
		foreach ($this->results as $result)
		{
			@mssql_free_result($result);
		}
	}
	
	private function _parse_major_version($version)
	{
		preg_match('/([0-9]+)\.([0-9]+)\.([0-9]+)/', $version, $ver_info);
		return $ver_info[1]; // return the major version b/c that's all we're interested in.
	}
	
	
}
?>