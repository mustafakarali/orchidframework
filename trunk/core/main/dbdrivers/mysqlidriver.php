<?php
class mysqlidriver extends abstractdbdriver
{

	function hi($a,$b,$c,$d)
	{
		echo "Hello";
		echo $a;
	}

	public function __construct($dbinfo)
	{
		if (!empty($dbinfo['dbname']))
		{
			$this->connection = mysqli_connect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpwd'],$dbinfo['dbname']);
		}
		else
		throw new Exception("You must supply username, password, hostname and database name for connecting to mysql");
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
		$this->results[$hash] = mysqli_query($this->connection,$sql);
		if("insert"==$type) return $this->insertId();
		return true;
	}

	public function count()
	{
		//print_r($this);
		$lastresult = $this->results[$this->lasthash];
		//print_r($this->results);
		$count = mysqli_num_rows($lastresult);
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
		if (function_exists('mysqli_real_escape_string'))
		{
			return mysqli_real_escape_string( $this->connection,$sql);
		}
		elseif (function_exists('mysqli_escape_string'))
		{
			return mysqli_escape_string($this->connection, $sql);
		}
		else
		{
			return addslashes($sql);
		}
	}


	public function affectedRows()
	{
		return @mysqli_affected_rows($this->connection);
	}

	public function insertId()
	{
		return @mysqli_insert_id($this->connection);
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



	function getRow($fetchmode = FETCH_ASSOC)
	{

		$lastresult = $this->results[$this->lasthash];
		if (FETCH_ASSOC == $fetchmode)
		$row = mysqli_fetch_row($lastresult);
		elseif (FETCH_ROW == $fetchmode)
		$row = mysqli_fetch_row($lastresult);
		elseif (FETCH_OBJECT == $fetchmode)
		$row = mysqli_fetch_object($lastresult);
		else
		$row = mysqli_fetch_array($lastresult,MYSQLI_BOTH);
		return $row;
	}

	function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
	{
		$lastresult = $this->results[$this->lasthash];
		if (!empty($offset))
		{
			mysqli_data_seek($lastresult, $offset);
		}
		return $this->getRow($fetchmode);
	}

	function rewind()
	{
		$lastresult = $this->results[$this->lasthash];
		mysqli_data_seek($lastresult, 0);
	}

	function getRows($start, $count, $fetchmode = FETCH_ASSOC)
	{
		$lastresult = $this->results[$this->lasthash];
		mysqli_data_seek($lastresult, $start);
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
			@mysqli_free_result($result);
		}
	}
	
	function getFields($table)
	{
		$this->execute("SHOW COLUMNS FROM {$table}");
		$fields = array();
		while ($row = $this->getRow())
		{
			$fields[] = $row['Field'];
		}
		return $fields;
	}


}
?>
