<?php
/**
 * The core unittest manager for orchid which helps to write inline unit tests
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class unittest
{
	private static $results = array();
	private static $testmode = false;

	public static function setUp()
	{
		$config = loader::load("config");
		if ($config->unit_test_enabled){

			self::$results = array();
			self::$testmode = true;
		}
	}

	public static function tearDown()
	{
		if (self::$testmode){
			self::printTestResult();
			self::$results = array();
			self::$testmode = false;
			die();
		}
	}

	public static function printTestResult()
	{
		foreach (self::$results as $result)
		{
			echo $result."<hr/>";
		}
	}


	public static function assertTrue($object)
	{
		if (!self::$testmode) return 0;
		if (true==$object) $result = "passed";
		self::saveResult(true, $object, $result);
	}

	public static function assertEqual($object, $constant)
	{
		if (!self::$testmode) return 0;
		if ($object==$constant)
		{
			$result = 1;
		}
		self::saveResult($constant, $object, $result);
	}

	private static function getTrace()
	{
		$result = debug_backtrace();
		$cnt = count($result);
		$callerfile = $result[2]['file'];
		$callermethod = $result[3]['function'];
		$callerline = $result[2]['line'];
		return array($callermethod, $callerline, $callerfile);
	}

	private static function saveResult($expected, $actual, $result=false)
	{
		if (empty($actual)) $actual = "null/false";

		if ("failed"==$result || empty($result))
		$result = "<font color='red'><strong>failed</strong></font>";
		else
		$result = "<font color='green'><strong>passed</strong></font>";

		$trace = self::getTrace();
		$finalresult = "Test {$result} in Method: <strong>{$trace[0]}</strong>. Line: <strong>{$trace[1]}</strong>. File: <strong>{$trace[2]}</strong>. <br/> Expected: <strong>{$expected}</strong>, Actual: <strong>{$actual}</strong>. ";
		self::$results[] = $finalresult;
	}

	public static function assertArrayHasKey($key, array $array, $message = '')
	{
		if (!self::$testmode) return 0;
		if (array_key_exists($key, $array))
		{
			$result = 1;
			self::saveResult("Array has a key named '{$key}'", "Array has a key named '{$key}'", $result);
			return ;
		}
		self::saveResult("Array has a key named '{$key}'", "Array has not a key named '{$key}'", $result);
	}

	public static function assertArrayNotHasKey($key, array $array, $message = '')
	{
		if (!self::$testmode) return 0;
		if (!array_key_exists($key, $array))
		{
			$result = 1;
			self::saveResult("Array has not a key named '{$key}'", "Array has not a key named '{$key}'", $result);
			return ;
		}
		self::saveResult("Array has not a key named '{$key}'", "Array has a key named '{$key}'", $result);

	}

	public static function assertContains($needle, $haystack, $message = '')
	{
		if (!self::$testmode) return 0;
		if (is_array($haystack)){
			if (in_array($needle,$haystack))
			{
				$result = 1;
				self::saveResult("Array has a needle named '{$needle}'", "Array has a needle named '{$needle}'", $result);
				return ;
			}
			self::saveResult("Array has a needle named '{$needle}'", "Array has not a needle named '{$needle}'", $result);
		}
		else 
		{
			if (strpos($haystack,$needle)!==false)
			{
				$result = 1;
				self::saveResult("Haystack has a needle named '{$needle}'", "Haystack has a needle named '{$needle}'", $result);
				return ;
			}
			self::saveResult("Haystack has a needle named '{$needle}'", "Haystack has not a needle named '{$needle}'", $result);
		}

	}

	public static function assertNull($object)
	{
		$this->assertTrue(isnull($object));
	}

	public static function assertNotTrue($object)
	{
		if (!self::$testmode) return 0;
		if (false==$object) $result = "passed";
		self::saveResult(true, $object, $result);
	}



	public static function assertIdentical($object, $constant)
	{
		$this->assertTrue($object===$constant);
	}

	public static function assertNotIdentical($object, $constant)
	{
		$this->assertTrue($object!==$constant);
	}

	public static function assertPattern($string, $pattern)
	{
		$match = preg_match($pattern, $string);
		$this->assertTrue($match);
	}

	public static function assertInstance($object1, $object2)
	{
		$this->assertTrue($object1 instanceof $object2);
	}
}
?>