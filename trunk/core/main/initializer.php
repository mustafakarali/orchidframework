<?php
/**
 * this initializer class initializes orchid for successful file inclusion.
 * it also converts every error to exception
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class initializer
{
	public static function initialize()
	{
		/*set_include_path(get_include_path().PATH_SEPARATOR."./core/main");
		set_include_path(get_include_path().PATH_SEPARATOR."./core/main/cache");
		set_include_path(get_include_path().PATH_SEPARATOR."./core/helpers");
		set_include_path(get_include_path().PATH_SEPARATOR."./core/libraries");
		//set_include_path(get_include_path().PATH_SEPARATOR."app/controllers");
		set_include_path(get_include_path().PATH_SEPARATOR."./app/models");
		set_include_path(get_include_path().PATH_SEPARATOR."./app/views");
		//include_once("core/config/config.php");*/
	}

	/*public static function exceptions_error_handler($severity, $message, $filename, $lineno) {
		throw new ErrorException($message, 0, $severity, $filename, $lineno);
	}*/
}

//set_error_handler(array("initializer",'exceptions_error_handler'),E_ALL);
?>