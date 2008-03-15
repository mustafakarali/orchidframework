<?php
/**
 * Router manages all the request and help dispatcher to dispatch them properly
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class router
{
	private $route;
	private $controller;
	private $action;
	private $params;
	public function __construct()
	{
		if(file_exists("app/config/routes.php")){
			include_once("app/config/routes.php");
		}

		$path = array_keys($_GET);
		$config = loader::load("config");
		if (!isset($path[0]))
		{
			$default_controller = $config->default_controller;
			if (!empty($default_controller))
			$path[0] = $default_controller;
			else 
			$path[0] = "index";
		}
		$route= $path[0];
		$sanitzing_pattern = $config->allowed_url_chars;
		$route = preg_replace($sanitzing_pattern, "", $route);
		$route = str_replace("^","",$route);
		$this->route = $route;

		$routParts = split( "/",$route);
		$this->controller=$routParts[0];
		$this->action=isset($routParts[1])? $routParts[1]:"base";
		array_shift($routParts);
		array_shift($routParts);
		$this->params=$routParts;

		/* match user defined routing pattern */
		if (isset($routes)){
			foreach ($routes as $_route)
			{
				$_pattern = "~{$_route[0]}~";
				$_destination = $_route[1];
				if (preg_match($_pattern,$route))
				{
					$newrouteparts = split("/",$_destination);
					$this->controller = $newrouteparts[0];
					$this->action = $newrouteparts[1];
				}
			}
		}
	}

	public function getAction()
	{
		if (empty($this->action)) $this->action="base";
		return $this->action;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getParams()
	{
		if (count($_POST)>0)
		{
			foreach ($_POST as $key=>$val)
			$this->params[$key]=$val;
		}
		$post->paramcounts=count($_POST);
		return $this->params;
	}
	
	public function getPostParams()
	{
		$post = new stdClass();
		if (count($_POST)>0)
		{
			foreach ($_POST as $key=>$val)
			$post->$key = $val;
		}
		$post->paramcounts=count($_POST);
		return $post;
	}
	
	public function getRoute()
	{
		return $this->route;
	}

}
?>