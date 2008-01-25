<?php
/**
 * This class helps to use language files.
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class lang
{
	private $lang;
	function __construct()
	{
		global $langs;
		include_once("app/config/langs.php");
		$this->lang = $langs;
	}
	
	private function __get($var)
	{
		return $this->lang[$var];
	}
}

?>