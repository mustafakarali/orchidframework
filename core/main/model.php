<?
class model{
	private $loaded = array();
	private function __get($model)
	{
		$model .="model";
		$modelfile = "app/models/{$model}.php";

		$config = loader::load("config");

		if (file_exists($modelfile))
		{
			include_once($modelfile);
			if (empty($this->loaded[$model]))
			{
				$this->loaded[$model]=new $model();
			}
			$modelobj = $this->loaded[$model];
			if ($config->auto_model_association){
				$post = array_merge($_POST,$_GET);
				$strictness = $config->auto_model_association_strict;
				$this->associate($modelobj, $post,$strictness); //auto association
			}
			return ( $modelobj);
		}
		else
		{
			throw new Exception("Model {$model} is not found");
		}


	}


	private function associate(&$obj, $array,$strict=false)
	{
		foreach ($array as $key=>$value)
		{
			if ($strict){
				if (property_exists($obj, $key)) //for strict operation
				{
					$obj->$key = $value;
				}
			}
			else
			$obj->$key = $value;
		}
	}
	
	


}
?>