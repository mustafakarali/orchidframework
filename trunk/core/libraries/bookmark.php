<?
class bookmark
{
	function addDelicious($title)
	{
		$title = urlencode($title);
		$docUrl = urlencode(getCurrentURL());
		$url="http://del.icio.us/post?v=4&noui&jump=close&url={$docUrl}&title={$title}";
		
		$image = loader::load("image");
		$bookmarkimage = $image->displayImageWithAlt("delicious.png","Bookmark this page on Del.icio.us",null,null,$url,"_blank",true);
		return $bookmarkimage;
	}
	
	function addStumbleUpon()
	{
		$title = urlencode($title);
		$docUrl = urlencode(getCurrentURL());
		$url="http://www.stumbleupon.com/submit?url={$docUrl}";
		
		$image = loader::load("image");
		$bookmarkimage = $image->displayImageWithAlt("stumbleupon.png","Bookmark this page on StumbleUpon",null,null,$url,"_blank",true);
		return $bookmarkimage;
	}
	
	function addTechnorati()
	{
		$title = urlencode($title);
		$docUrl = urlencode(getCurrentURL());
		$url="http://www.technorati.com/faves?add={$docUrl}";
		
		$image = loader::load("image");
		$bookmarkimage = $image->displayImageWithAlt("technorati.png","Bookmark this page on StumbleUpon",null,null,$url,"_blank",true);
		return $bookmarkimage;
	}
}
?>