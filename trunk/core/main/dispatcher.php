<?
class dispatcher
{
	public static function dispatch($router)
	{
		global $app;
		//$cache = loader::load("cache");
		ob_start();
		$config = loader::load("config");

		if ($config->global_profile) $start = microtime(true);

		$controller = $router->getController();
		$action = $router->getAction();
		$params = $router->getParams();

		//$cache->invalidate("abcde");

		/*if (!$cache->isExpired("abcde"))
		{
		$content = $cache->get("abcde");
		$content = base64_decode($content['content']);
		die($content);
		}*/

		if (count($params)>=1){
			if ("unittest"==$params[count($params)-1] || '1'==$_POST['unittest'])
			unittest::setUp();
		}

		$redirect=true;
		while($redirect){
			$controllerfile = "app/controllers/{$controller}.php";

			if (!file_exists($controllerfile)){
				throw new Exception("Controller not found");
			}
			require_once($controllerfile);
			$app = new $controller();
			if (empty($app->use_layout)) //so that you can also override the use_layout behavior
			$app->use_layout = true; 
			$app->use_view = true; 
			$app->setParams($params);
			$app->$action();
			
			//check if the controller calls for a redirect
			if(empty($app->redirectcontroller)) 
			$redirect=false;
			else 
			{
				//die("called a redirect");
				$controller = $app->redirectcontroller;
				$action = $app->redirectaction;
				$app->redirectcontroller="";
				$app->redirectaction="";
			}
			//end redirect processing
		}


		unittest::tearDown();
		$rawoutput = ob_get_clean();

		//manage view
		ob_start();

		$view = loader::load("view");
		$viewvars = $view->getVars($app);
		$uselayout = $config->use_layout;

		if (!$app->use_layout) $uselayout=false;

		$template = $view->getTemplate($action);
		
		if ($app->use_view==true)
		base::_loadTemplate($controller, $template, $viewvars, $uselayout);
		else 
		echo $rawoutput;
		
		if (isset($start))
		echo "<div style='clear:both;'><p style='padding-top:25px;' >Total time for dispatching is : ".(microtime(true)-$start)." seconds.</p></div>";
		$output = ob_get_clean();

		//$cache->set("abcde",array("content"=>base64_encode($output)));
		echo $output;


	}
}
?>