<?php
$configs['debug']="on";


$configs['autoload_prototype']=false;
$configs['autoload_scriptaculous']=false;
$configs['autoload_jquery']=true;
$configs['global_profile']=true;

$configs['use_layout']=false;
$configs['auto_model_association']=true;
$configs['auto_model_association_strict']=false;
$configs['unit_test_enabled']=false;

$configs['cache_sqlite']['dbname']="sqlite.sq2"; //absolute path

$configs['cache_mysql']['dbname']="test";
$configs['cache_mysql']['dbuser']="root";
$configs['cache_mysql']['dbhost']="localhost";
$configs['cache_mysql']['dbpass']="root1234";
$configs['cache_mysql']['dbpersistence']=true;

$configs['cache_memcache']['servers'][]=array("host"=>"127.0.0.1","port"=>"11211");
$configs['cache_memcache']['servers'][]=array("host"=>"","port"=>"");
$configs['cache_memcache']['servers'][]=array("host"=>"","port"=>"");


$configs['cache_source'] = ""; //or mysql or memcache

$configs['allowed_url_chars'] = "/[^@%A-z0-9\/\.\^]/";


/* DB */
$configs['db']['usedb']="";
$configs['db']['production']['dbname']="";
$configs['db']['production']['dbhost']="";
$configs['db']['production']['dbuser']="";
$configs['db']['production']['dbpwd']="";
$configs['db']['production']['persistent']="";
$configs['db']['production']['dbtype']="";

$configs['db']['test']['dbname']="";
$configs['db']['test']['dbhost']="";
$configs['db']['test']['dbuser']="";
$configs['db']['test']['dbpwd']="";
$configs['db']['test']['persistent']="";
$configs['db']['test']['dbtype']="";

$configs['db']['development']['dbname']="test";
$configs['db']['development']['dbhost']="localhost";
$configs['db']['development']['dbuser']="root";
$configs['db']['development']['dbpwd']="root1234";
$configs['db']['development']['persistent']=true;
$configs['db']['development']['dbtype']="mysql";


$configs['use_session_db']=false;
$configs['session_table']=null;

$configs['js_gzip_enabled']=false;
$configs['char_encoding'] = "utf-8";

$configs['session_auto_start'] = false;
$configs['catch_all_controller'] = "";

$configs['base_url']=str_replace("/index.php","",$_SERVER['PHP_SELF'])."";
$configs['base_url']="http://122.248.7.196/hasin/orchidframework";
?>
