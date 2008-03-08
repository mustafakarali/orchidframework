<?php
/*
CREATE TABLE `sessions` (
`id` varchar(32) NOT NULL,
`access` int(10) default NULL,
`data` text,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

*/
/**
 * This is the custom session handler which allows managing both DB based and regular sessions
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class session
{
	private $maxTime;
	private $sessionTable;


	public function __get($var)
	{
		return $_SESSION[$var];
	}

	public function __set($key, $val)
	{
		$_SESSION[$key]=$val;
	}

	public function start()
	{
		session_start();
	}

	public function unsetKey($key)
	{
		$_SESSION[$key]="";
		unset($_SESSION[$key]);
	}

	public function destroy()
	{
		session_destroy();
	}

	public function clear()
	{
		foreach ($_SESSION as $key=>$val){
			$_SESSION[$key]="";
			unset($_SESSION[$key]);
		}
	}


	public function __construct()
	{
		$config = loader::load("config");

		if ($config->use_session_db)
		{
			$table = $config->session_table;
			if (!empty($table)){

				$this->sessionTable = $config->session_table;
				$this->maxTime = get_cfg_var('session.gc_maxlifetime');
				session_set_save_handler(
				array( $this, "_open" ),
				array( $this, "_close" ),
				array( $this, "_read" ),
				array( $this, "_write"),
				array( $this, "_destroy"),
				array($this,"_gc")
				);

			}
		}
		$this->start();
	}

	public function _open() {
		return true;
	}

	public function _close()
	{
		$time = time();
		$db = loader::load("db");
		$db->execute("DELETE FROM {$this->sessionTable} WHERE ($time-access>{$this->maxTime})");
		return true;
	}

	public function _write($id, $data)
	{
		//die("Writing");
		//if (strpos(getcwd(),"bin")!==false) chdir("../htdocs/ab"); //specially for Vista::temporary solution
		$db = loader::load("db");
		$time = time();
		$data = addslashes($data);
		$db->execute("REPLACE INTO {$this->sessionTable} VALUES ('{$id}', '{$time}', '{$data}')");
		return true;
	}

	public function _read($id)
	{
		$db = loader::load("db");
		$time = time();
		$db->execute("SELECT * FROM {$this->sessionTable} WHERE id='{$id}' AND ($time-access<={$this->maxTime})");
		$result = $db->getRow();
		//$data = unserialize(stripslashes($result['data']));
		return $result['data'];
	}

	public function _destroy($id)
	{
		$db = loader::load("db");
		$result = $db->execute("DELETE FROM {$this->sessionTable} WHERE id='{$id}' ");
		return true;
	}

	public function _gc()
	{

	}


}
?>