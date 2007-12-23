<?
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
}
?>