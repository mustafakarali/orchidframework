<?php
class Widget
{
	private $options = array(

	"name"=>"",
	"themeengine"=>"",
	"type"=>"",
	"callback"=>"",
	"data"=>"",
	"refreshinterval"=>"",
	"id"=>"",
	"position"=>array("left"=>"","top"=>"","width"=>"","height"=>""),
	"style"=>"",
	"class"=>""
	);

	/**
	 * available widget types
	 *
	 * text
	 * applet --that is application + aplet = heh heh, notice there is double p
	 * rss
	 * youtube
	 * html
	 * flash
	 * slideshow
	 * flv
	 * iframe
	 * weblet - for fetching remote contents
	 */

	public function __construct($options)
	{
		$this->options = $options;
	}

	public function render()
	{
		$id = $this->options['id'];
		$type = $this->options['type'];
		$data = $this->options['data'];
		$style = $this->options['style'];
		$class = $this->options['class'];
		$callback = $this->options['callback'];
		$name = $this->options['name'];
		$theme = $this->options['theme'];
		$refreshinterval=$this->options['refreshinterval'];
		$position=$this->options['position'];
		if ($type=="text" || $type=="html")
		{
			//process text based widgets
			$output  = "<div id='{$id}' class='widget {$class}' style='{$style}'>";
			if(!empty($name))
			$output .= "<h2 class='widgettitle'>{$name}</h2>";
			$output .= "<div class='widgetdata'>{$data}</div>";
			$output .= "</div>";
		}
		else if($type=="rss")
		{
			$url = $data;
			$config = loader::load("config");
			$googleApiKey = $config->google_api;

			$output = "
				
				<div id='{$id}' class='widget {$class}' style='{$style}'>
				<h2 class='widgettitle'>{$name}</h2>
				<div class='widgetdata'>
				<script type=\"text/javascript\" src=\"http://www.google.com/jsapi?key={$googleApiKey}\"></script>
			    <script type=\"text/javascript\">
				    $('#{$id}').gFeed({  
				        url: '{$data}', 
				        title: ''
				    });     
			    </script>
			    </div>
			    ";
		}

		return $output;
	}
}

?>