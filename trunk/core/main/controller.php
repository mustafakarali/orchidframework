<?
class controller
{
	private $params;
	public $redirectcontroller;
	public $redirectaction;
	public $use_view=true;
	public $use_layout=true;
	public $post;
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
	
	function base(){}
}
?>