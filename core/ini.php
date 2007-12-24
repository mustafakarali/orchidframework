<?
/**
 * this initializer class initializes orchid for successful file inclusion 
 * and autoloading objects.
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
error_reporting(E_ALL - (E_NOTICE+E_WARNING));
include_once("core/helpers/general.php");
//include_once("core/libraries/unittest.php");
/*set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/main");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/libraries");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/main/dbdrivers");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/main/cache");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/js");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/core/helpers");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/app/models");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/app/views");
set_include_path(get_include_path().PATH_SEPARATOR.getcwd()."/app/controllers");
define('CLASS_DIR', 'core/main/');*/
function __autoload($object)
{
	/* temporary fix for db.php */
	/*if ($object=="db")
	{
	//for vista test
		require_once(base::basePath()."/core/main/db.php");
		return;
	}*/
	
	$path = array(
		getcwd()."/core/main",
		getcwd()."/core/libraries",
		getcwd()."/core/main/dbdrivers",
		getcwd()."/core/main/cache",
		getcwd()."/core/helpers",
		getcwd()."/app/models",
		getcwd()."/app/views"
	);
	
	foreach ($path as $p)
	{
		$filename = $p.DIRECTORY_SEPARATOR."{$object}.php";
		if (file_exists($filename))
		{
			//echo $filename." 1 <br/>";
			include_once($filename);
			break;
		}
		else 
		{
			//echo "<pre>";
			//print_r(debug_backtrace());
			//echo getcwd()."<br/>";
			//echo $filename."<br/>";
		}
		
	}
	/*echo "core/libraries/{$object}.php<BR/>";
	echo file_exists("core/libraries/{$object}.php")."<br/>";
	if (file_exists("core/main/{$object}.php"))
	require_once("core/main/{$object}.php");
	else if (file_exists("core/main/dbdrivers/{$object}.php"))
	require_once("core/main/dbdrivers/{$object}.php");
	else if (file_exists("core/main/cache/{$object}.php"))
	require_once("core/main/cache/{$object}.php");
	else if (file_exists("core/libraries/{$object}.php")){
		require_once("core/libraries/{$object}.php");
	}
	else if (file_exists("core/js/{$object}.php"))
	require_once("core/js/{$object}.php");
	else if (file_exists("core/helpers/{$object}.php"))
	require_once("core/helpers/{$object}.php");
	else if (file_exists("app/models/{$object}.php"))
	require_once("app/models/{$object}.php");
	else if (file_exists("app/views/{$object}.php"))
	require_once("app/views/{$object}.php");
	else*/ 
	
	
}
?>