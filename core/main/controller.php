<?php
/**
 * Abstract controller class whish is responsible for managing default behaviour of 
 * controller objects
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
Abstract class controller
{
	private $params;
	public $redirectcontroller;
	public $redirectaction;
	public $use_view=true;
	public $use_layout=true;
	public $post;
	public $template;
	private $errors;
	public $error=false;
	
	function __construct()
	{
		$this->errors = array();
	}
	
	private function __get($var)
	{
		if ($var == "params")
		return $this->params;
		return loader::load($var);
	}
	
	public function setParams($params)
	{
		$this->params = $params;
	}
	
	public function setPostParams($post)
	{
		$this->post = $post;
	}
	
	public function redirect($controller, $action="base")
	{
		$this->redirectcontroller=$controller;
		$this->redirectaction=$action;
	}
	
	public function redirectUrl($controller, $action="base")
	{
		$baseurl = base::baseUrl();
		$url = $baseurl."/{$controller}/{$action}";
		header("location: {$url}");
		die();
	}
	
	public function setView($view)
	{
		$this->template = $view;
	}
	
	public function setError($errorMsg)
	{
		$this->errors[md5($errorMsg)]= $errorMsg;//to avoid storing multiple errors for many times, used this hash
		$this->error = true;
	}
	
	public function getError()
	{
		return $this->errors;
	}
	
	function base(){}
}
?>