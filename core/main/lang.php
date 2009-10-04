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
        if(empty($lang) && file_exists("app/config/langs.php"))
        include_once("app/config/langs.php");
        else if(file_exists("app/config/langs.{$lang}.php"))
        include_once("app/config/langs.{$lang}.php");
        $this->lang = $langs;
    }

    private function __get($var)
    {
        return $this->lang[$var];
    }

    public function loadLang($lang)
    {
        $langfile = "app/config/langs.{$lang}.php";
        if(!file_exists($langfile))
        {
            throw new Exception("Language app/config/langs.{$lang}.php not found");
        }
        else{
            include($langfile);
            $this->lang = $langs;
        }
    }
}

?>