<?php

class image
{
	/**
	 * for easyly embedding images in app
	 */

	function displayImage($filename="",$width=null, $height=null,$url="", $target="",$return=false)
	{
		$imagepath = base::baseUrl()."/app/images/{$filename}";
		$tag = "<img border=0 src='{$imagepath}' />";
		$tag2 = "<img  border=0 src='{$imagepath}' width='{$width}px' />";
		$tag3 = "<img  border=0 src='{$imagepath}' height='{$height}px'/>";
		$tag4 = "<img  border=0 src='{$imagepath}' height='{$height}px' width='{$width}px'/>";

		if (!empty($url)){
			$prefix = "<a href='{$url}' target='{$target}' >";
			$suffix = "</a>";
		}

		if($return==false){
			if (empty($height) && empty($width))
			echo $prefix.$tag.$suffix;
			elseif (!empty($width) && !empty($height))
			echo $prefix.$tag4.$suffix;
			elseif (!empty($width))
			echo $prefix.$tag2.$suffix;
			elseif(!empty($height))
			echo $prefix.$tag3.$suffix;
		}
		elseif($return==true){
			if (empty($height) && empty($width))
			return $prefix.$tag.$suffix;
			elseif (!empty($width) && !empty($height))
			return $prefix.$tag4.$suffix;
			elseif (!empty($width))
			return $prefix.$tag2.$suffix;
			elseif(!empty($height))
			return $prefix.$tag3.$suffix;
		}
	}
	
	function displayImageWithAlt($filename="",$alt="", $width=null, $height=null,$url="", $target="",$return=false)
	{
		$imagepath = base::baseUrl()."/app/images/{$filename}";
		$tag = "<img title='{$alt}' alt='{$alt}' border=0 src='{$imagepath}' />";
		$tag2 = "<img title='{$alt}' alt='{$alt}'  border=0 src='{$imagepath}' width='{$width}px' />";
		$tag3 = "<img title='{$alt}' alt='{$alt}'  border=0 src='{$imagepath}' height='{$height}px'/>";
		$tag4 = "<img title='{$alt}' alt='{$alt}'  border=0 src='{$imagepath}' height='{$height}px' width='{$width}px'/>";

		if (!empty($url)){
			$prefix = "<a href='{$url}' target='{$target}' >";
			$suffix = "</a>";
		}

		if($return==false){
			if (empty($height) && empty($width))
			echo $prefix.$tag.$suffix;
			elseif (!empty($width) && !empty($height))
			echo $prefix.$tag4.$suffix;
			elseif (!empty($width))
			echo $prefix.$tag2.$suffix;
			elseif(!empty($height))
			echo $prefix.$tag3.$suffix;
		}
		elseif($return==true){
			if (empty($height) && empty($width))
			return $prefix.$tag.$suffix;
			elseif (!empty($width) && !empty($height))
			return $prefix.$tag4.$suffix;
			elseif (!empty($width))
			return $prefix.$tag2.$suffix;
			elseif(!empty($height))
			return $prefix.$tag3.$suffix;
		}
	}

	function getUrl($filename="")
	{
		$imagepath = base::baseUrl()."/app/images/{$filename}";
		return $imagepath;
	}
}
?>