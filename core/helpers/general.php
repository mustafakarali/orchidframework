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
	 * @return unknown
	 */
function SimpleXMLToArray($xml)
{
	if ($xml instanceof SimpleXMLElement) {
		$children = $xml->children();
		$return = null;
	}

	foreach ($children as $element => $value) {
		if ($value instanceof SimpleXMLElement) {
			$values = (array)$value->children();

			if (count($values) > 0) {
				$return[$element] = XMLToArray($value);
			} else {
				if (!isset($return[$element])) {
					$return[$element] = (string)$value;
				} else {
					if (!is_array($return[$element])) {
						$return[$element] = array($return[$element], (string)$value);
					} else {
						$return[$element][] = (string)$value;
					}
				}
			}
		}
	}

	if (is_array($return)) {
		return $return;
	} else {
		return $false;
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

?>