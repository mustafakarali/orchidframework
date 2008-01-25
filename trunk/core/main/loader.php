<?php
/**
 * This class makes successful loading of any object through out orchid framework
 * in a very resource intensive way. 
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class loader
{
	private static $loaded = array();
	public static function load($object)
	{
		$valid = array(	"library",
		"view",
		"model",
		"helper",
		"router",
		"config",
		"hook",
		"cache",
		"db",
		"session",
		"ajax",
		"json",
		"lang");

		if (!in_array($object,$valid))
		{

			$config = self::load("config");
			if ("on"==$config->debug)
			{
				base::backtrace();
			}
			throw new Exception("Not a valid object '{$object}' to load");
		}

		if (empty(self::$loaded[$object])){
			self::$loaded[$object]= new $object();
		}
		return self::$loaded[$object];

	}

}
?>
