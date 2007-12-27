<?php
include_once("dbdrivers/abstract.dbdriver.php");
class db
{
	private $dbengine;
	private $state  = "development";
	private static $latestquery;

	public function __construct()
	{
		$config = loader::load("config");
		$dbengineinfo = $config->db;
		
		if (empty($dbengineinfo[$this->state]['dbtype']))
		throw new Exception("You must specify database driver details.");
		if ($dbengineinfo['usedb']!=false)
		{
			
			$driver = $dbengineinfo[$this->state]['dbtype'].'driver';
			include_once("dbdrivers/{$driver}.php");
			$dbengine = new $driver($dbengineinfo[$this->state]);
			$this->dbengine = $dbengine;
		}
	}

	public function setDbState($state)
	{
		//must be 'development'/'production'/'test' or whatever
		if (empty($this->dbengine)) return 0;
		$config = loader::load("config");
		$dbengineinfo = $config->db;
		if (isset($dbengineinfo[$state]))
		{
			$this->state = $state;
		}
		else
		{
			throw new Exception("No such state in config filed called ['db']['{$state}']");
		}
	}

	private function __call($method, $args)
	{
		if (empty($this->dbengine)) return 0;
		if (!method_exists($this, $method)){
			if ($method=="execute")
			self::$latestquery = $args[0];
			return call_user_func_array(array($this->dbengine,$method),$args);
		}
	}
	
	public function getLatestQuery()
	{
		return self::$latestquery;
	}

	/*private function __get($property)
	{
	if (property_exists($this->dbengine,$property))
	return $this->dbengine->$property;
	}*/
}
?>