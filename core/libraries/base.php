<?php
/**
 * base provides some core functions and act as a global helper through out the application
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class base{
	public static function pr($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	public static function backtrace()
	{
		echo "<pre>";
		debug_print_backtrace();
		echo "</pre>";
	}

	public static function basePath()
	{
		return getcwd();
	}

	public static function baseUrl()
	{
		$conf = loader::load("config");
		return $conf->base_url;
	}

	public static function _loadTemplate($controller, $template, $vars, $uselayout=false){
		extract($vars);
		$baseurl = base::baseUrl();
		if ($uselayout)
		ob_start();
		$templatefile ="app/views/{$controller}/{$template}.php";
		if (file_exists($templatefile)){
			include_once($templatefile);
		}
		else
		{
			throw new Exception("View '{$template}.php' is not found in views/{$controller} directory.");
		}

		if ($uselayout) {
			$layoutdata = ob_get_clean();
			$layoutfilelocal = "app/views/{$controller}/{$controller}.php";
			$layoutfileglobal = "app/views/layouts/{$controller}.php";

			if (file_exists($layoutfilelocal))
			include_once($layoutfilelocal);
			else
			include_once($layoutfileglobal);
		}
	}


	function isIE()
	{
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($agent,"MSIE")!==false) return true;
		return false;
	}

	function isIE7()
	{
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($agent,"MSIE 7.0")!==false) return true;
		return false;
	}
}
?>