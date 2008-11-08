<?php
header("Content-type: text/javascript; charset: UTF-8");
?>
var baseUrl = "<?=base::baseUrl();?>";

function addFLVPlayer(playerurl,url, width, height, container,preview, allowfullscreen)
{
	var s1 = new SWFObject(playerurl,"single",width,height,"7");
	s1.addParam("allowfullscreen",allowfullscreen);
	s1.addVariable("file",url);
	if (preview!="")
	s1.addVariable("image",preview);
	s1.addVariable("width",width);
	s1.addVariable("height",height);
	s1.write(container);

function isIE()
{
	if (document.all) return true;
	return false;
}

function submitForm(formId)
{
	formId = "#"+formId;

	//if (!action)
	action = $(formId).attr("action");
	type = $(formId).attr("type");
	if (type=="") type="text";
	container = "#"+$(formId).attr("container");
	callback = function(data,result)
	{
		if(type=="json")
		{
			//alert(data.callback);
			var func = eval(data.callback);
			func(data);
		}
		else
		$(container).parent().html(data);
	}
	data = $(formId).serializeArray();
	$.post(action,data, callback,type);
	return false;
}

function loadComponent(div, url, warning)
{
	//alert("ding");
	if(warning)
	{
		var res = confirm("Are you sure you want to do this?");
		if(!res)
		return;
	}
	$("#"+div).html(loading);
	$.post(url,{},function(data){
		$('#'+div).html(data).find(".bangla").each(function(e,input){
			activeta=$(input).attr("id");
			setBanglaContextMenu(activeta);
			makePhoneticEditor(activeta);
		});
	});
}

function loadWidget(div, url,data, callback)
{
	$("#"+div).html(loading);
	if (!data) data = {};
	$.post(url,data,function(data){
		$('#'+div).html(data).find(".widget").each(function(e,widget){
			var widgetName = $(widget).attr("id");
			var state = $.cookie("st"+widgetName);
			if (state=="") state="block";
			try {
				$(widget).find(".widgetdata").css("display",state);
			} catch (e)
			{
				// The nastry line # 24 error fix fixed here...mu ha ha ha ha
			}
		});

		$('#'+div).find(".bangla").each(function(e,input){
			activeta=$(input).attr("id");
			setBanglaContextMenu(activeta);
			makePhoneticEditor(activeta);
		});
		if(callback)
		callback(data);
	});
}

function loadCallbackComponent(url, data, callback)
{
	//$("#"+div).html(loading);
	if (!data) data = {};
	$.post(url,data,function(data2){
		callback(data2);
	},"json");
}

function collapse(ths)
{
	//alert(ths.id);
	$(ths).next('.widgetdata').toggle(200,function()
	{
		var state = $(ths).next('.widgetdata').css("display");
		var widgetName  = "st"+$(ths).parent().attr("id");
		//alert(widgetName+"\n"+state);
		$.cookie(widgetName,state,{"expires":-1});
		$.cookie(widgetName,state,{"expires":10});
		//alert($.cookie(widgetName));
	});
	//$(ths).find("span:first").html("Hello There");
}

function genericMessage(jsonResponse)
{
	if(jsonResponse.status!="data")
	alert(jsonResponse.message);
	//alert(jsonResponse.component)
	$("#"+jsonResponse.component).val(jsonResponse.value);
}

function num2hex(num)
{
	num = new Number(num);
	return num.toString(16);
}

function hex2num(hex)
{
	return parseInt(hex,16);
}

function parseYT()
{
	$('a[@href^="http://youtube.com"]').flash(
	{ height: 370, width: 450},
	{ version: 8 },
	function(htmlOptions) {
		$this = $(this);
		htmlOptions.src = $this.attr('href');
		$this.before("<div style='width:450px;height:370px;border:1px solid #000'>"+$.fn.flash.transform(htmlOptions)+"</div>");
	}
	);
}

function getWindowDimensions()
{
	var myWidth = 0, myHeight = 0;

	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}

	var dimensions = new Array(myWidth, myHeight);
	return dimensions;
}