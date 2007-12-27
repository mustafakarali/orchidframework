<?php
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
	
	this.isIE = function()
	{
		if (document.all) return true;
		return false;
	}
	
	/* Original Cookie Script written by Scott Andrew (http://www.scottandrew.com) */
	this.createCookie = function(name,value,days)
	{
		if (days)
		{
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	
	this.readCookie =  function(name)
	{
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++)
		{
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	this.eraseCookie = function(name)
	{
		this.createCookie(name,"",-1);
	}
	//cookie functions end
}

