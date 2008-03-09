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
			$data.="<td valign='top' style='{$tdstyle}'>{$Array[$i-1]}</td>";
			else
			$data.="<td valign='top' style='{$tdstyle}'><a href=\"{$urls[$i-1]}\">{$Array[$i-1]}</a></td>";

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
	$data = "";
	$prevpage = $currentpage-1;

	if ($total<=$numberperpage) return "&nbsp;";
	$lastpage = ceil($total/$numberperpage);

	if ($lastpage > 5 && $currentpage>3) {
		# if middle point should be > 3
		if ($lastpage-$currentpage>1) {
			# if gap between middle and last is > 1
			$middlepoint = $currentpage;
		} else {
			# otherwise middle should be respect to last
			$middlepoint = $lastpage - 2;
		}
	} else {
		$middlepoint = 3;
	}

	if ($middlepoint>3)
	{
		$data .="<a href='{$callback}1'>First</a>&nbsp;&nbsp;\n";
	}

	if ($currentpage>1)
	{
		$data .="<a href='{$callback}{$prevpage}'>Prev</a>&nbsp;&nbsp;\n";
	}


	$startpoint=$middlepoint-2;

	$endpoint =  ($lastpage > 5) ? $middlepoint+2 : $lastpage;

	//echo $startpoint;
	for($i=$startpoint; $i<=$endpoint; $i++)
	{
		if ($i == $currentpage)
		$data .= "<span><a href='{$callback}{$i}'><strong>{$i}</strong></a></span>";
		else
		$data .= "<span><a href='{$callback}{$i}'>{$i}</a></span>";
		if ($i < $endpoint)
		$data .= "&nbsp;&nbsp;\n";
	}

	$pageid	 = $currentpage + 1;

	if ($currentpage<($lastpage)){
		$data .="<span><a href='{$callback}{$pageid}'>Next</a></span>";
	}

	if (($lastpage-$currentpage)>2){
		$data .="<span><a href='{$callback}{$lastpage}'>Last</a></span>";
	}
	return $data;
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
?>