<?
echo "Welcome to Command Line Tool of Orchid \n";

switch ($argv[1] ){

case "skeleton":
	$appname = $argv[2];
	echo "Creating a dummy app";
	try{
		mkdir(getcwd()."/app");
		mkdir(getcwd()."/app/cache");
		mkdir(getcwd()."/app/config");
		mkdir(getcwd()."/app/controllers");
		mkdir(getcwd()."/app/js");
		mkdir(getcwd()."/app/libraries");
		mkdir(getcwd()."/app/models");
		mkdir(getcwd()."/app/views");
		
		$str = "<?
		\$configs['base_url']=\"please set your application url here\";
		?>";
		$filename = getcwd()."/app/config/configs.php";
		file_put_contents($filename,$str);
	}
	catch (Exception $e)
	{
		//echo $e;
	}
	break;
case "controller":
	$controllername = $argv[2];
	$filename = getcwd()."/app/controllers/{$controllername}.php";
	$dir = getcwd()."/app/views/{$controllername}";
	$filename2 = getcwd()."/app/views/{$controllername}/base.php";
	$filename3 = getcwd()."/app/views/{$controllername}/hello.php";

	if (file_exists($filename))
	echo "This controller already exists";
	else{
		$str ="<?
class {$controllername} extends controller
{
	function base()
	{
		\$this->view->set(\"name\",'{$controllername}');
	}
	
	function hello()
	{
		\$this->view->set(\"param1\",'World');
	}
}
?>
";

		file_put_contents($filename,$str); //write the controller
		mkdir($dir);
		
		$str2 ="
Called from <?=\$name;?>/base method 
";

		$str3 ="
Hello <?=\$param1;?>
";
	}
	
	file_put_contents($filename2,$str2); //write the controller
	file_put_contents($filename3,$str3); //write the controller
	break;
}
?>