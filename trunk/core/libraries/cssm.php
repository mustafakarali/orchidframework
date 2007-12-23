<?
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
}
?>