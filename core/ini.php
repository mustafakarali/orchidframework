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
	}
	
	
}
?>