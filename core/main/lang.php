<?php
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