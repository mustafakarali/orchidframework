<?php
/**
 * sanitize user inputs from malicious attacks
 * @todo : need improvement
 *
 */
class sanitizer
{
	/**
	 * sanitize $_GET, $_POST and $_COOKIE
	 *
	 */
	public function sanitizeUserInput()
	{
		$input = array("GET"=>$_GET, "POST"=>$_POST, "COOKIE"=>$_COOKIE);
		foreach ($input as $key=> &$array)
		{
			foreach ($array as $_key => $_value)
			{
				${$key}[$_key] = $this->sanitize($_value); 
			}
		}
	}
	
	private function sanitize($value)
	{
		if (get_magic_quotes_gpc())
		$value = addslashes($value);
		return  $value;
	}
	
	public function sanitizeUriComponent()
	{
		
	}
}
?>