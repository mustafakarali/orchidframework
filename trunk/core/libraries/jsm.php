<?
/**
 * Javascript Manager
 *
 */
class jsm
{
	private $gzipenabled = false;
	function loadPrototype()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=prototypec.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/prototypec.js' ></script>\n";
	}
	function loadScriptaculous()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=scriptaculousc.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/scriptaculousc.js' ></script>\n";
	}
	function loadProtaculous()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled){
			echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=prototypec.js' ></script>\n";
			echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=scriptaculousc.js'></script>\n";
		}
		else {
			echo "<script type='text/javascript' src='{$base}/core/js/prototypec.js' ></script>\n";
			echo "<script type='text/javascript' src='{$base}/core/js/scriptaculousc.js'></script>\n";
		}
	}
	function loadJquery()
	{
		$base = base::baseUrl();
		if ($this->gzipenabled)
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=jqueryc.js' ></script>\n";
		else
		echo "<script type='text/javascript' src='{$base}/core/js/jqueryc.js' ></script>\n";
	}
	/**
	 * app specific libraries
	 *
	 * @param string $filename
	 */
	function loadScript($filename)
	{
		$base = base::baseUrl();
		$script = $base."/app/js/{$filename}.js";
		echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js={$script}' ></script>\n";
	}

	function loadButtonJS()
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
	}

	function __construct()
	{
		$config = loader::load("config");
		$this->gzipenabled = $config->js_gzip_enabled;
	}
}
?>