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
	
	function createThumbnail($oldImage, $newImage,$width=150, $height="")
	{
		$t = new thumbnail_images();
		$t->PathImgOld = $oldImage;
		$t->PathImgNew=$newImage;
		$t->NewHeight = $height;
		$t->NewWidth=$width;
		if ($t->create_thumbnail_images()) return true;
		return false;
	}

}


class thumbnail_images {

	// get
	public $PathImgOld;
	public $PathImgNew;
	public $NewWidth;
	public $NewHeight;

	// tmp
	public $mime;

	function imagejpeg_new ($NewImg,$path_img) {
		if ($this->mime == 'image/jpeg' or $this->mime == 'image/pjpeg') imagejpeg($NewImg,$path_img);
		elseif ($this->mime == 'image/gif') imagegif($NewImg,$path_img);
		elseif ($this->mime == 'image/png') imagepng($NewImg,$path_img);
		else return(false);
		return(true);
	}

	function imagecreatefromjpeg_new($path_img) {
		if ($this->mime == 'image/jpeg' or $this->mime == 'image/pjpeg') $OldImg=imagecreatefromjpeg($path_img);
		elseif ($this->mime == 'image/gif') $OldImg=imagecreatefromgif($path_img);
		elseif ($this->mime == 'image/png') $OldImg=imagecreatefrompng($path_img);
		else return(false);
		return($OldImg);
	}

	function  create_thumbnail_images() {
		$PathImgOld = $this->PathImgOld;
		$PathImgNew = $this->PathImgNew;
		$NewWidth = $this->NewWidth;
		$NewHeight = $this->NewHeight;

		$Oldsize = @getimagesize($PathImgOld);
		$this->mime = $Oldsize['mime'];
		$OldWidth = $Oldsize[0];
		$OldHeight = $Oldsize[1];

		if ($NewHeight=='' and $NewWidth!='') {
			$NewHeight = ceil(($OldHeight*$NewWidth)/$OldWidth);
		}
		elseif ($NewWidth=='' and $NewHeight!='') {
			$NewWidth = ceil(($OldWidth*$NewHeight)/$OldHeight);
		}
		elseif ($NewHeight=='' and $NewWidth=='') {
			return(false);
		}

		$OldHeight_castr = ceil(($OldWidth*$NewHeight)/$NewWidth);
		$castr_bottom = ($OldHeight-$OldHeight_castr)/2;

		$OldWidth_castr = ceil(($OldHeight*$NewWidth)/$NewHeight);
		$castr_right = ($OldWidth-$OldWidth_castr)/2;

		if ($castr_bottom>0) {
			$OldWidth_castr = $OldWidth;
			$castr_right = 0;
		}
		elseif ($castr_right>0) {
			$OldHeight_castr = $OldHeight;
			$castr_bottom = 0;
		}
		else {
			$OldWidth_castr = $OldWidth;
			$OldHeight_castr = $OldHeight;
			$castr_right = 0;
			$castr_bottom = 0;
		}
		
		if($OldHeight_castr<$NewHeight) $NewHeight=$OldHeight_castr;
		if($OldWidth_castr<$NewWidth) $NewWidth = $OldWidth_castr;

		$OldImg=$this->imagecreatefromjpeg_new($PathImgOld);
		if ($OldImg) {
			$NewImg_castr=imagecreatetruecolor($OldWidth_castr,$OldHeight_castr);
			if ($NewImg_castr) {
				imagecopyresampled($NewImg_castr,$OldImg,0,0,$castr_right,$castr_bottom,$OldWidth_castr,$OldHeight_castr,$OldWidth_castr,$OldHeight_castr);
				$NewImg=imagecreatetruecolor($NewWidth,$NewHeight);
				if ($NewImg) {
					imagecopyresampled($NewImg,$NewImg_castr,0,0,0,0,$NewWidth,$NewHeight,$OldWidth_castr,$OldHeight_castr);
					imagedestroy($NewImg_castr);
					imagedestroy($OldImg);
					if (!$this->imagejpeg_new($NewImg,$PathImgNew)) return (false);
					imagedestroy($NewImg);
				}
			}
		}
		else {
			return(false);
		}

		return(true);
	}
}
?>