<?
header("Content-type: text/javascript; charset: UTF-8");
?>
function orchid()
{
	this.addFLVPlayer= function(playerurl,url, width, height, container,preview, allowfullscreen)
	{
		var s1 = new SWFObject(playerurl,"single",width,height,"7");
		s1.addParam("allowfullscreen",allowfullscreen);
		s1.addVariable("file",url);
		if (preview!="")
		s1.addVariable("image",preview);
		s1.addVariable("width",width);
		s1.addVariable("height",height);
		s1.write(container);

	}
}

