<?php
class pdodriver extends abstractdbdriver
{
	private $pdo;
	private $affectedrows;

	public function __construct($dbinfo)
	{
		if (!empty($dbinfo['dbname']))
		{
			$this->pdo  = new PDO($dbinfo['dbname'],$dbinfo['dbuser'],$dbinfo['dbpwd']);
		}
		else
		throw new Exception("You must supply dsn, username and password for connecting via pdo");
	}

	public function execute($sql)
	{
		$sql = $this->prepQuery($sql);
		$parts = split(" ",trim($sql));
		$type = strtolower($parts[0]);
		$hash = md5($sql);
		$this->affectedrows=0;

		if ("select"==$type)
		{
			if (isset($this->results[$hash]))
			{
				$this->lasthash = $hash;
				if (is_resource($this->results[$hash]))
				return $this->results[$hash];
			}
			else {

				$this->results[$hash] = $this->pdo->prepare($sql);
				$this->results[$hash]->execute();
				return $this->results[$hash];
			}
		}
		else{
			$this->results = array(); //clear the result cache
			$this->affectedrows=  $this->pdo->exec($sql);
		}

		if("insert"==$type) return $this->insertId();
		return true;

	}

	public function count()
	{
		//print_r($this);
		$lastresult = $this->results[$this->lasthash];
		//print_r($this->results);
		$count = $lastresult->rowCount();
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
		return $sql;
	}


	public function affectedRows()
	{
		return $this->affectedRows();
	}

	public function insertId()
	{
		return $this->pdo->lastInsertId();
	}


	public function transBegin()
	{
		$this->pdo->beginTransaction();
		return true;
	}

	public function transCommit()
	{
		$this->pdo->commit();
		return true;
	}


	public function transRollback()
	{
		$this->pdo->rollBack();
		return true;
	}



	public function getRow($fetchmode = FETCH_ASSOC)
	{

		$lastresult = $this->results[$this->lasthash];
		if (FETCH_ASSOC == $fetchmode)
		$row = $lastresult->fetch(PDO::FETCH_ASSOC);
		elseif (FETCH_ROW == $fetchmode)
		$row =  $lastresult->fetch(PDO::FETCH_NUM);
		elseif (FETCH_OBJECT == $fetchmode)
		$row =  $lastresult->fetch(PDO::FETCH_OBJ);
		else
		$row =  $lastresult->fetch(PDO::FETCH_BOTH);
		return $row;
	}

	public function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
	{
		if (!empty($offset))
		$lastresult = $this->results[$this->lasthash];
		$lastresult->execute();
		for($i=0; $i<$offset;$i++)
		$lastresult->fetch();
		return $this->getRow($fetchmode,$fetchmode);
	}

	public function rewind()
	{
		$lastresult = $this->results[$this->lasthash];
		$lastresult->execute();
	}

	public function getRows($start, $count, $fetchmode = FETCH_ASSOC)
	{
		$lastresult = $this->results[$this->lasthash];
		$lastresult->execute;
		for($i=0; $i<$start;$i++)
		$lastresult->fetch();
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
			@pdo_free_result($result);
		}
	}
	

}
?>
