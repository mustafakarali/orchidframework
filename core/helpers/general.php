<?php
/**
 * A general library containing some helper methods
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
/**
	 * @author : Jason Sheets <jsheets at shadonet dot com>
	 *
	 * @param unknown_type $xml
	 * @return Array
	 */
function SimpleXMLToArray($sxml)
{
	$arr = array();
	if ($sxml) {
		foreach ($sxml as $k => $v) {
			if ($sxml['list']) {
				$arr[] = SimpleXMLToArray($v);
			} else {
				$arr[$k] = SimpleXMLToArray($v);
			}
		}
	}
	if (sizeof($arr) > 0) {
		return $arr;
	} else {
		return (string)$sxml;
	}
}

/**
 * Makes a nice HTML table from a supplied array. 
 *
 * @param array 	$Array Array of data
 * @param int 		$NumberOfColumn How many columns you want
 * @param int 		$Width Width of the table
 * @param string 	$Style style of the table
 * @param int 		$CellSpacing cell spacing
 * @param int 		$CellPadding cell padding
 * @param string	$align alignment of the table
 * @param string	$tdstyle TD style
 * @param array		$urls URLs if you want to make your cell data clickable
 * @return string	A nicely formatted HTML Table
 */
function arrayToTable($Array, $NumberOfColumn=3, $Width=100, $Style=null, $CellSpacing=0 , $CellPadding=0, $align="left", $tdstyle = "",$urls=null)
{
	$data = "<table align='{$align}' width='{$Width}%' cellspacing={$CellSpacing} cellpadding={$CellPadding} style='{$Style}'>";


	$tdwidth = 100/$NumberOfColumn;
	$ActualRow = ceil(count($Array)/$NumberOfColumn)*$NumberOfColumn;
	//echo $ActualRow;
	for ($i=1; $i<=$ActualRow; $i++)
	{
		if ($i%$NumberOfColumn==1){
			$data .= "<tr>";
		}

		//echo count($Array);
		$_fix = $NumberOfColumn-count($Array);
		if (count($Array)<$NumberOfColumn)
		{
			for ($n=0;$n<$_fix;$n++)
			{
				$Array[] = "&nbsp;";
			}
		}
		if ($i<=count($Array))
		{
			if (empty($urls))
			$data.="<td valign='top' width='{$tdwidth}%' style='{$tdstyle}' >{$Array[$i-1]}</td>";
			else
			$data.="<td valign='top' width='{$tdwidth}%' style='{$tdstyle}'><a href=\"{$urls[$i-1]}\">{$Array[$i-1]}</a></td>";

		}

		if ($i%$NumberOfColumn==0)
		{
			$data .="</tr>";
		}

	}
	$data .="</table>";
	return $data;
}

function createPagination($total, $callback, $numberperpage, $currentpage)
{
	$start=1;
	$end = 9;
	echo '<ul class="pagination">';



	$pages = ceil($total/$numberperpage);

	if($currentpage>5 && $pages>9)
	{
		$start=$currentpage-4;
		$end = $currentpage+4;
	}
	if($end>$pages) $end = $pages;
	if($start>1) {
		echo "<li><a href='{$callback}1' style='cursor:pointer' >&nbsp;&lt;&lt;&nbsp;</a></li>\n";
		//echo "<li>... ...</li>";
	}
	if ($currentpage>1)
	{
		$prevPage = $currentpage-1;
		echo "<li><a href='{$callback}{$prevPage}' style='cursor:pointer' >&nbsp;&lt;&nbsp;</a></li>\n";
	}
	for($i=$start;$i<=$end;$i++)
	{
		$ii = numberToBUnicode($i);
		if($i==$currentpage)
		echo "<li><a href='{$callback}{$i}' class='active' style='cursor:pointer' >{$ii}</a></li>\n";
		else
		echo "<li><a href='{$callback}{$i}' style='cursor:pointer' >{$ii}</a></li>\n";
	}


	if ($currentpage<=($pages-1))
	{
		$nextPage = $currentpage+1;
		echo "<li><a href='{$callback}{$nextPage}' style='cursor:pointer' >&nbsp;&gt;&nbsp;</a></li>\n";
	}
	//if($pages>$end) echo "<li>... ...</li>";
	echo "<li><a href='{$callback}{$pages}' style='cursor:pointer' >&nbsp;&gt;&gt;&nbsp;</a></li>\n";
	echo '</ul>';
}



function allEmpty()
{
	$args = func_get_args();
	foreach ($args as $item)
	if (!empty($item))
	return false;

	return true;
}

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
	/*
	$interval can be:
	yyyy - Number of full years
	q - Number of full quarters
	m - Number of full months
	y - Difference between day numbers
	(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
	d - Number of full days
	w - Number of full weekdays
	ww - Number of full weeks
	h - Number of full hours
	n - Number of full minutes
	s - Number of full seconds (default)
	*/

	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds

	switch($interval) {

		case 'yyyy': // Number of full years

		$years_difference = floor($difference / 31536000);
		if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
			$years_difference--;
		}
		if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
			$years_difference++;
		}
		$datediff = $years_difference;
		break;

		case "q": // Number of full quarters

		$quarters_difference = floor($difference / 8035200);
		while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			$months_difference++;
		}
		$quarters_difference--;
		$datediff = $quarters_difference;
		break;

		case "m": // Number of full months

		$months_difference = floor($difference / 2678400);
		while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
			$months_difference++;
		}
		$months_difference--;
		$datediff = $months_difference;
		break;

		case 'y': // Difference between day numbers

		$datediff = date("z", $dateto) - date("z", $datefrom);
		break;

		case "d": // Number of full days

		$datediff = floor($difference / 86400);
		break;

		case "w": // Number of full weekdays

		$days_difference = floor($difference / 86400);
		$weeks_difference = floor($days_difference / 7); // Complete weeks
		$first_day = date("w", $datefrom);
		$days_remainder = floor($days_difference % 7);
		$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
		if ($odd_days > 7) { // Sunday
			$days_remainder--;
		}
		if ($odd_days > 6) { // Saturday
			$days_remainder--;
		}
		$datediff = ($weeks_difference * 5) + $days_remainder;
		break;

		case "ww": // Number of full weeks

		$datediff = floor($difference / 604800);
		break;

		case "h": // Number of full hours

		$datediff = floor($difference / 3600);
		break;

		case "n": // Number of full minutes

		$datediff = floor($difference / 60);
		break;

		default: // Number of full seconds (default)

		$datediff = $difference;
		break;
	}

	return $datediff;

}

function getCurrentURL()
{
	$router = loader::load("router");
	$url = base::baseUrl()."/".$router->getRoute();
	return $url;
}

function generatePassword ($length = 6)
{

	// start with a blank password
	$password = "";

	// define possible characters
	$possible = "0123456789bcdfghjkmnpqrstvwxyz!#@";

	// set up a counter
	$i = 0;

	// add random characters to $password until $length is reached
	while ($i < $length) {

		// pick a random character from the possible ones
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

		// we don't want this character if it's already in the password
		if (!strstr($password, $char)) {
			$password .= $char;
			$i++;
		}

	}

	// done!
	return $password;

}

function createAjaxPagination($total, $callback, $numberperpage, $currentpage)
{
	echo '<ul class="pagination">';

	if ($currentpage>1)
	{
		$prevPage = $currentpage-1;
		echo "<li><a href='#' style='cursor:pointer' onclick='{$callback}({$prevPage});'>Prev</a></li>\n";
	}
	$pages = ceil($total/$numberperpage);


	for($i=1;$i<=$pages;$i++)
	{
		if($i==$currentpage)
		echo "<li><a href='#' class='active' style='cursor:pointer' onclick='{$callback}($i);'>{$i}</a></li>\n";
		else
		echo "<li><a href='#' style='cursor:pointer' onclick='{$callback}($i);'>{$i}</a></li>\n";
	}

	//echo $total;
	if ($currentpage<=($pages))
	{
		$nextPage = $currentpage+1;
		echo "<li><a href='#' style='cursor:pointer' onclick='{$callback}({$nextPage});'>Next</a></li>\n";
	}
	echo '</ul>';
}

function isPOST()
{
	if (count($_POST)>0)
	return true;
	return false;
}

function def(&$var, $default)
{
	$var= empty($var)?$default:$var;
}

/**
 * copied from aman's blog at mailtoaman.com
 *
 * @param unknown_type $text
 * @param unknown_type $n
 * @return unknown
 */
function truncate($text,$n){
	return substr($text = substr($text,0,$n)
	,0,
	strrpos($text,' ')
	);
}

function isIE()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"MSIE")!==false) return true;
	return false;
}

function isFF()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"Firefox")!==false) return true;
	return false;
}

function isIE6()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"MSIE 6")!==false) return true;
	return false;
}

function isIE7()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"MSIE 7")!==false) return true;
	return false;
}

function isOpera()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"Opera")!==false) return true;
	return false;
}

function isFF3()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"Firefox/3")!==false) return true;
	return false;
}

function isFF2()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"Firefox/2")!==false) return true;
	return false;
}

function isMacintosh()
{
	$sa =  $_SERVER['HTTP_USER_AGENT'];
	if(strpos($sa,"Macintosh")!==false) return true;
	return false;
}

function getFeedParsedByGoogle($url, $items=5, $nocache=0)
{
	$feedurl = "http://www.google.com/uds/Gfeeds?num={$items}&hl=en&output=json&q=".urlencode($url)."&v=1.0&nocache={$nocache}";
	$filedata = file_get_contents($feedurl);
	$djson = json_decode($filedata);
	return $djson;
}

?>