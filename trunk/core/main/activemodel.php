<?
class activemodel
{
	public $hasmany = "";
	private $results=array("id"=>null);
	public $tablename;

	public function clean()
	{
		$properties = get_class_vars(get_class($this));
		//die(print_r($properties));
		foreach ($properties as $prop=>$val)
		{
			//echo $prop;
			unset($this->$prop);
		}
	}

	public function insert()
	{
		$tablename = $this->tableName();
		$db = loader::load("db");
		$db->execute("show fields from {$tablename}");
		//echo $db->count();
		$fields=$values=array();
		while($row = $db->getRow())
		{
			$fieldname = $row['Field'];
			$fields[]= $fieldname;
			$values[] = !isset($this->{$fieldname})?'null':"'{$this->$fieldname}'";
		}
		$query = "INSERT INTO {$tablename}(".join(",",$fields).") VALUES(".join(",",$values).")";
		$result = $db->execute($query);
		//die($tablename);
	}

	public function update($condition=null,$primary="id")
	{
		//print_r($this);
		$tablename = $this->tableName();
		$db = loader::load("db");
		$db->execute("show fields from {$tablename}");
		//echo $db->count();
		$fields=$values=array();
		while($row = $db->getRow())
		{
			$fieldname = $row['Field'];
			//$f$fields[]= $fieldname;
			$values[] = $fieldname." = ".(!isset($this->{$fieldname})?'null':"'{$this->$fieldname}'");
		}
		if (empty($condition)){
			if (!empty($this->$primary)){
				$query = "UPDATE {$tablename} SET ".join(",",$values)." WHERE {$primary}='{$this->$primary}'";
			}
			else
			{
				throw new Exception("Your model must have value set to primary key field for successful update");
			}
		}
		else
		$query = "UPDATE {$tablename} SET ".join(",",$values)." WHERE {$condition}";
		
		//die($query);
		$result = $db->execute($query);

		//die($tablename);
	}

	public function find($conditions, $limit=1)
	{
		$condition = array();
		$tablename = $this->tableName();
		$db = loader::load("db");

		if (empty($conditions))
		$clause = "";
		else if (is_array($conditions))
		$clause = "WHERE ". join(" and ",$conditions);
		else
		$clause = "WHERE ".$conditions;

		/*if (!empty($this->hasmany))
		{
		$join = "";
		foreach ($this->hasmany as $key=>$relation)
		{
		$join .= " LEFT JOIN {$key} on {$relation['rule']} ";
		}
		}*/
		$query = "SELECT * FROM {$tablename}  {$clause} LIMIT {$limit}";
		$results=array();
		$db->execute($query);
		//echo $query;
		if ($db->count()==0)
		return array();

		for($i=0;$i<$limit; $i++)
		{
			$data = $db->getRow();
			if (!empty($data))
			$results[] = $data;
		}

		if (count($results)==1){
			foreach($results[0] as $key=>$value)
			{
				$this->$key = $value;
			}
			$results = $results[0]; //for accessing like getName(), getField()
		}

		//base::pr($results);
		//die();
		$this->results = $results;
		return $results;

	}

	public function findById($id)
	{
		$condition = array();
		$tablename = $this->tableName();
		$db = loader::load("db");
		if(!empty($id))
		{
			$query = "SELECT * FROM {$tablename} WHERE id={$id} LIMIT 1";
			$db->execute($query);
			$result = $db->getRow();
			$this->results = $result;
			foreach($result as $key=>$value)
			{
				$this->$key = $value;
			}
			return $result;
		}
	}


	private function tableName($pluralcontext=false)
	{
		if (empty($this->tablename))
		{
			$tablename = get_class($this);
			if ($pluralcontext)
			$tablename = str_replace("model","s",$tablename); //plural context
			else
			$tablename = str_replace("model","",$tablename); //plural context

			$this->tablename = $tablename;
		}
		else
		{
			$tablename = $this->tablename;
		}

		return $tablename;
	}


	public function __call($method, $args)
	{
		//for accessing the record like $model->getField()
		if (!empty($this->results))
		{
			if (strpos($method,"get")!==false)
			{
				$fieldname = str_replace("get","",strtolower($method));
				return $this->results[$fieldname];
			}
			elseif (strpos($method,"set")!==false)
			{
				$fieldname = str_replace("set","",strtolower($method));
				$this->results[$fieldname] = $args[0];
			}
		}
	}

	public function save($primarykey = "id")
	{
		if (!empty($this->results) && !empty($this->results[$primarykey]))
		{
			$parts = array();
			foreach ($this->results as $field=>$data)
			{

				$parts[] = " {$field} = '{$data}' ";
			}

			$values = join (" , ",$parts);


			$tableName = $this->tableName();
			$query = "UPDATE {$tableName} SET {$values} WHERE {$primarykey} = '{$this->results[$primarykey]}' ";
			$db = loader::load("db");
			$db->execute($query);
		}
	}

	public function __construct($tablename = "")
	{
		$this->tablename = $tablename;
	}


}
?>