<hr />
<?
$app->library->jsm->loadjQuery();
$ajax = $app->library->ajax;
?>
<p><strong>visual_effect</strong> - Hide  / Show.</p>
<?=$ajax->link_to_function('hide',$ajax->visual_effect('hide','#hideshow'));?>&nbsp;&nbsp;
<?=$ajax->link_to_function('show',$ajax->visual_effect('show','#hideshow'));?>
<div id='hideshow' style="width : 200px; background-color : #ff0000; display: block; ">
<br />
<br />
<br />
<br />
</div>

<hr />
<p><strong>visual_effect</strong> - fadeIn / fadeOut.</p>
<?=$ajax->link_to_function('fadeOut',$ajax->visual_effect('fadeOut','#fade'));?>&nbsp;&nbsp;
<?=$ajax->link_to_function('fadeIn',$ajax->visual_effect('fadeIn','#fade'));?>


<div id='fade' style="background-color : #ff0000; display: block;">
<br />
<br />
<br />
<br />
</div>

<hr />
<p><strong>visual_effect</strong> - slideToggle with callback.</p>
<?=$ajax->link_to_function('slidetoggle',$ajax->visual_effect('slideToggle','#toggle',array('callback'=>'alert("Callback");')));?>
<div id='toggle' style=" width : 200px; background-color : #ff0000; ">
<br />
<br />
<br />
<br />
</div>
