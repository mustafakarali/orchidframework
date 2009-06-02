<?php
/**
 * Javascript loader which helps developr to load javascripts easily through out the application
 * It supports gzip compression.
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class jsm
{
	private $gzipenabled = false;
	/*function loadPrototype()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.2/prototype.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.2/prototype.js' ></script>\n";
	}
	function loadScriptaculous()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.1/scriptaculous.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.1/scriptaculous.js' ></script>\n";
	}*/
	
	/*function addAccordion()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=accordion.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/accordion.js' ></script>\n";
	}*/
	/*function loadProtaculous()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled){
			echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.2/prototype.js' ></script>\n";
			echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.1/scriptaculous.js'></script>\n";
		}
		else {
			echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.2/prototype.js' ></script>\n";
			echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.1/scriptaculous.js'></script>\n";
		}
	}
	function loadJquery()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' ></script>\n";
	}*/
	/**
	 * app specific libraries
	 *
	 * @param string $filename
	 */
	function loadScript($filename, $version)
	{
		if (!empty($version))
		$versionString = "?v={$version}";
		$base = base::baseUrl();
		$script = $base."/app/js/{$filename}.js";
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/app/js/gzip.php?js={$script}' ></script>\n";
		else 
		echo "<script type='text/javascript' src='{$script}{$versionString}' ></script>\n";

	}

	/*function loadButtonJS()
	{
		$this->loadJquery();
		?>
		<script>
		$(document).ready(function(){
			$('.btn, .btnC,.btnR, .btnC2').each(function(){
				var b = $(this);
				var tt = b.text() || b.val();
				if ($(':submit,:button',this)) {
					b = $('<a>').insertAfter(this). addClass(this.className).attr('id',this.id);
					$(this).remove();
				}
				b.text('').css({cursor:'pointer'}). prepend('<i></i>').append($('<span>').
				text(tt).append('<i></i><span></span>'));
			});


		});

		</script>
		<?
	}*/
	
	/*function addSWFObject()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=swfobject.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/swfobject.js' ></script>\n";
	}*/
	
	function addOrchidHelper()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=general.php' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/general.php' ></script>\n";
	}
	
	/*function addPNGFix()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=pngfix.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/pngfix.js' ></script>\n";
	}
	
	function addThickBox()
	{
		$this->loadJquery();
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=thickbox.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/thickbox.js' ></script>\n";
		
		$lib = loader::load("library");
		$lib->cssm->addThickBox();
	}*/
	
	function addGenericVars()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript'>";
		echo "var baseurl=\"{$base}\";";
		echo "</script>";
	}

	function __construct()
	{
		$config = loader::load("config");
		$this->gzipenabled = $config->js_gzip_enabled;
		$this->addGenericVars();
	}
	
	/*function addIE8()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=ie8.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/ie8.js' ></script>\n";
	}*/
	
	function addjQueryFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js' ></script>\n";
	}
	
	function addjQueryUIFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js' ></script>\n";
	}
	function addPrototypeFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js' ></script>\n";
	}
	function addScriptaculousFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js' ></script>\n";
	}
	function addMootoolsFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools-yui-compressed.js' ></script>\n";
	}
	function addDojoFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/dojo/1.3.1/dojo/dojo.xd.js' ></script>\n";
	}
	function addSWFObjectFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js' ></script>\n";
	}
	function addYahooUIFromGoogle()
	{
		$base = base::baseUrl();
		echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/yui/2.7.0/build/yuiloader/yuiloader-min.js' ></script>\n";
	}
}
?>
