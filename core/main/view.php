<?php
/**
 * this initializer class initializes orchid for successful file inclusion.
 * it also converts every error to exception
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class view
{
	private $vars=array();
	private $template;

	public function __construct()
	{
		$config = loader::load("config");
		$this->vars['base_url']=$config->base_url;
	}
	public function set($key, $value)
	{
		$this->vars[$key]=$value;
		//base::pr($this->vars);
	}

	public function getVars(&$controller=null)
	{
		if (!empty($controller)) $this->vars['app']=$controller;
		return $this->vars;
	}

	public function setTemplate($template)
	{
		$this->template = $template;
	}

	public function getTemplate($controller=null)
	{
		if (empty($this->template)) return $controller;
		return $this->template;
	}

	private function __get($var)
	{
		return loader::load($var);
	}

	public function addComponentView($controller,$view="base")
	{
		$basepath = base::basePath();
		$filepath = $basepath."/app/views/{$controller}/{$view}.php";
		include($filepath);
	}

	public function addRenderedView($url, $postparams, $return=true)
	{
		//header("content-type: text/html; charset=utf-8");
		$url= urldecode($url);
		$content = http_build_query($postparams);
		$result = $this->do_post_request($url,$content);
		if ($return)
		return $result;
		else 
		echo $result;
	}

	private function do_post_request($url, $data, $optional_headers = null)
	{
		/* Thanks to Wez Furlong and Sara Goleman */
		$params = array('http' => array(
		'method' => 'POST',
		'content' => $data
		));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			throw new Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		return $response;
	}
}
?>