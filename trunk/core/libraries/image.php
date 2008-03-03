<?php

class image
{
	/**
	 * for easyly embedding images in app
	 */
	
	function displayImage($filename="",$width=null, $height=null)
	{
		$imagepath = base::baseUrl()."/app/images/{$filename}";
		$tag = "<img src='{$imagepath}' />";
		$tag2 = "<img src='{$imagepath}' width='{$width}px' />";
		$tag3 = "<img src='{$imagepath}' height='{$height}px'/>";
		$tag4 = "<img src='{$imagepath}' height='{$height}px' width='{$width}px'/>";
		
		if (empty($height) && empty($width))
		echo $tag;
		elseif (!empty($width) && !empty($height))
		echo $tag4;
		elseif (!empty($width))
		echo $tag2;
		elseif(!empty($height))
		echo $tag3;
	}
	
	function getUrl($filename="")
	{
		$imagepath = base::baseUrl()."/app/images/{$filename}";
		return $imagepath;
	}
}
?>