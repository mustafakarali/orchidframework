<?php
/**
 * for general file inclusion
 *
 */
class helper{
	private $loaded = array();
	private function __get($helper)
	{

		$helpernameapp = "app/helpers/{$helper}.php";
		if (file_exists($helpernameapp))
		{
			require_once($helpernameapp);
			//$this->loaded[$helper]=new $helper();
		}
		else
		{
			$helpernamecore = "core/helpers/{$helper}.php";
			if (file_exists($helpernamecore))
			{
				require_once($helpernamecore);
			}
			else
			{
				throw new Exception("Helper {$helper} not found.");
			}
		}

	}
}
?>