<?php
class cssm
{
	public function addScalableButtonCSS()
	{
		$basepath = base::baseUrl();
		echo "<style type=\"text/css\"> @import \"{$basepath}/core/styles/btn.php\"; </style>";
		$lib = loader::load("library");
		$lib->jsm->loadButtonJS();
	}
	
	public function addParticleTreeButtonCSS()
	{
		$basepath = base::baseUrl();
		echo "<style type=\"text/css\"> @import \"{$basepath}/core/styles/pt.php\"; </style>";
	}
	
	public function addCSS($filename,$extension="css")
	{
		$basepath = base::baseUrl();
		echo "<style type=\"text/css\"> @import \"{$basepath}/app/styles/{$filename}.{$extension}\"; </style>";
	}
	
	public function addThickBox()
	{
		$basepath = base::baseUrl();
		echo "<style type=\"text/css\"> @import \"{$basepath}/core/styles/thickbox.css\"; </style>";
	}
	
	public function addBluePrint($iehack=true)
	{
		$basepath = base::baseUrl();
		echo "<style type=\"text/css\"> @import \"{$basepath}/core/styles/bp.css\"; </style>";
		if ($iehack)
		echo "<style type=\"text/css\"> @import \"{$basepath}/core/styles/ie.css\"; </style>";
	}
}
?>