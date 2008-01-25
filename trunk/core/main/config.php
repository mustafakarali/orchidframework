<?php
/**
 * The core class for managing configuration directives through out the application
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class config
{
	private $config;
	function __construct()
	{
		global $configs;
		include_once("core/config/configs.php");
		include_once("app/config/configs.php");
		$this->config = $configs;
	}
	
	private function __get($var)
	{
		return $this->config[$var];
	}
}
?>