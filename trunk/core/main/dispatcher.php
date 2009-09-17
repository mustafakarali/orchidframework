<?php
/**
 * The dispatcher is responsible for loading and all dispatching all the requests
 * with the help of router, view, model and loader. 
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class dispatcher
{
	public static function dispatch($router)
	{
		global $app;
		ob_start();
		$config = loader::load("config");
		if ($config->session_auto_start)
		{
			$session = loader::load("session");
			//if (isset($_REQUEST['PHPSESSID'])) {
				//session_id($_REQUEST['PHPSESSID']);
			//}
			$session->start();
		}

		$char_encoding = $config->char_encoding;
		if (empty($char_encoding)) $char_encoding="utf-8";
		header("Content-Type: text/html; charset={$char_encoding}");

		if ($config->global_profile) $start = microtime(true);

		$controller = $router->getController();
		$action = $router->getAction();
		$params = $router->getParams();


		if (count($params)>=1){
			if ("unittest"==$params[count($params)-1] || '1'==$_POST['unittest'])
			unittest::setUp();
		}

		$redirect=true;
		while($redirect){
			$controllerfile = "app/controllers/{$controller}.php";
			if (!file_exists($controllerfile)){
				//check for catch_all_controller
				$catchAllController = $config->catch_all_controller;
				if (empty($catchAllController))
				throw new Exception("Controller [{$controller}] not found. Referrer was {$_SERVER['HTTP_REFERER']}");
				else
				{
					//here the fun begins
					$_controller = $controller;
					$controller = $catchAllController;
					$controllerfile = "app/controllers/{$controller}.php";
				}
			}
			require_once($controllerfile);
			$app = new $controller($params);
			if ($catchAllController)
			{
				$app->catchAllController = $_controller;
				$app->catchAllAction=$action;
				$action="catchAll";
			}

			$helper = loader::load("helper");
			$cm = $helper->common; //load the common helper from app directory

			$app->setParams($params);
			$app->setPostParams($router->getPostParams());

			//add pre action hook execution
			$preActionHooks = $app->getPreActionHooks();
			if(!empty($preActionHooks))
			{
				foreach ($preActionHooks as $preHook)
				$app->$preHook();
			}
			//execute the action
			$app->use_layout = $config->use_layout;
			$app->$action();


			//add post action hook execution
			$postActionHooks = $app->getPostActionHooks();
			if(!empty($postActionHooks))
			{
				foreach ($postActionHooks as $postHook)
				$app->$postHook();
			}

			//check if the controller calls for a redirect
			if(empty($app->redirectcontroller))
			$redirect=false;
			else
			{
				//die("called a redirect");
				$controller = $app->redirectcontroller;
				$action = $app->redirectaction;
				$params = $app->params;
				$postparams = $app->post;
				$app->redirectcontroller="";
				$app->redirectaction="";
				if(!empty($params))
				$app->params = $params;
				if(!empty($postparams))
				$app->post= $postparams;
			}
			//end redirect processing
		}


		unittest::tearDown();
		$rawoutput = ob_get_clean();

		//manage view
		ob_start();

		$view = loader::load("view");
		$view->set("_errors",$app->getError());
		$viewvars = $view->getVars($app);

		$uselayout=$app->use_layout; //modified june 21 for easy overriding via any controller

		if (!empty($app->template))
		$view->setTemplate($app->template);
		$template = $view->getTemplate($action);


		if ($app->use_view==true){
			base::_loadTemplate($controller, $template, $viewvars, $uselayout);
			//$app->cssm->addCoreCSS();
		}
		else
		echo trim($rawoutput);

		if (isset($start))
		echo "<div style='clear:both;'><p style='padding-top:25px;' >Total time for dispatching is : ".(microtime(true)-$start)." seconds.</p></div>";
		$output = ob_get_clean();
		echo trim($output);

	}
}
?>
