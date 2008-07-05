<?
class postmodel extends activemodel 
{
	public $name;
	public $roll;
	
	public function getPost()
	{
		$router = loader::load("router");
		unittest::assertEqual($router->getAction(), "base");
		return  "Hello";
	}
}
?>