<?php
/**
 * This class acts as a loader of model objects. It also support use of null models in case
 * there is not physical file for that specific model. 
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class model{
	private $loaded = array();
	private $nullmodel= false;
	private function __get($model)
	{
		$_model= $model;
		$model .="model";
		$modelfile = "app/models/{$model}.php";

		if (!file_exists($modelfile)){
			$this->nullmodel=true;
			$modelfile = "core/models/nullmodel.php";
		}

		$config = loader::load("config");

		if (file_exists($modelfile))
		{
			include_once($modelfile);
			if (empty($this->loaded[$model]))
			{
				if (!$this->nullmodel)
				$this->loaded[$model]=new $model();
				else 
				$this->loaded[$model]=new nullmodel($_model);
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