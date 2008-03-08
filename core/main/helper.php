<?php
/**
 * Helper helps to perform a general inclusion of any file from helpers directory. 
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class helper{
	private $loaded = array();
	private function __get($helper)
	{

		$helpernameapp = "app/helper/{$helper}.php";
		if (file_exists($helpernameapp))
		{
			require_once($helpernameapp);
		}
		else
		{
			$helpernamecore = "core/helper/{$helper}.php";
			if (file_exists($helpernamecore))
			{
				require_once($helpernamecore);
			}
		}

	}
}
?>