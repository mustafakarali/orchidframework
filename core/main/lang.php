<?php
/**
 * This class helps to use language files.
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
class lang
{
    private $lang;
    function __construct($lang)
    {
        global $langs;
        if(empty($lang))
        include_once("app/config/langs.php");
        else
        include_once("app/config/langs.{$lang}.php");
        $this->lang = $langs;
    }

    private function __get($var)
    {
        return $this->lang[$var];
    }

    public function loadLang($lang)
    {
        include("app/config/langs.{$lang}.php");
        $this->lang = $langs;
    }
}

?>