<?php
/**
 * This class helps profiling controller actions
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class benchmark
{
	private $times = array();
	private $keys = array();

	public function setMarker($key=null)
	{
		$this->keys[] = $key;
		$this->times[] = microtime(true);
	}

	public function initiate()
	{
		$this->keys= array();
		$this->times= array();
	}

	public function printReport()
	{
		$cnt = count($this->times);
		$result = "";
		for ($i=1; $i<$cnt; $i++)
		{
			$key1 = $this->keys[$i-1];
			$key2 = $this->keys[$i];
			$seconds = $this->times[$i]-$this->times[$i-1];
			$result .= "For step '{$key1}' to '{$key2}' : {$seconds} seconds.</br>";
		}
		$total = $this->times[$i-1]-$this->times[0];
		$result .= "Total time  : {$total} seconds.</br>";
		echo $result;
	}
}
?>