<?
class postmodel extends activemodel 
{
	public $name;
	public $roll;
	
	public $hasmany = array(
			"comments"=>array(
				"rule"=>"comments.post_id=posts.id"
			)
	);
	
	
	public function getPost()
	{
		$router = loader::load("router");
		unittest::assertEqual($router->getAction(), "base");
		return  "Hello";
	}
}
?>