<?
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

$configs['cache_mysql']['dbname']="";
$configs['cache_mysql']['dbuser']="";
$configs['cache_mysql']['dbhost']="";
$configs['cache_mysql']['dbpass']="";
$configs['cache_mysql']['dbpersistence']=false;

$configs['cache_memcached']['server1']="";
$configs['cache_memcached']['server2']="";
$configs['cache_memcached']['server3']="";
$configs['cache_memcached']['server4']="";

$configs['cache_source'] = "sqlite"; //or cache_mysql or cache_memcached

$configs['allowed_url_chars'] = "/[^A-z0-9\/\^]/";


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
?>
