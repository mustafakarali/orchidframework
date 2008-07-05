<?php
$configs['debug']="on";


$configs['autoload_prototype']=false;
$configs['autoload_scriptaculous']=false;
$configs['autoload_jquery']=true;

/**
 * global_profile is used to turn on time calculation per request. if you set it to "true", orchid will display the
 * total time required to process the current request.
 */
$configs['global_profile']=true;

/**
 * use_layout is used to turn on layout system for view. if set to true, orchid will not directly display the output generated from
 * a view, but it merge the output with the layout file. 
 */
$configs['use_layout']=false;

/**
 * if auto_model_association is set to true orchid will assosciate each of the $_REQUEST parameters as a property of the model,
 * and you dont have to manually set them. 
 */
$configs['auto_model_association']=true;

/**
 * if set to true, auto_model_association_strict will populate only those parameters which already exists. very useful when someone
 * want to populate only the required parameter for inserting or updating. 
 */
$configs['auto_model_association_strict']=false;

/**
 * if unit test is enabled, users can write inline unit tests and can access by adding /unittest at the end of the request url anytime.
 */
$configs['unit_test_enabled']=false;

/**
 * if someone want to use sqlite as a caching server, here are the configurations. it is stored under app/cache folder. so you 
 * must chmod that file/folder to 766
 */
$configs['cache_sqlite']['dbname']="sqlite.sq2"; //absolute path

/**
 * if someone want to use mysql as a caching server, here are the configurations
 */
$configs['cache_mysql']['dbname']="test";
$configs['cache_mysql']['dbuser']="root";
$configs['cache_mysql']['dbhost']="localhost";
$configs['cache_mysql']['dbpass']="root1234";
$configs['cache_mysql']['dbpersistence']=true;

/**
 * if someone want to use memcache as the caching server, here are the configurtions
 */
$configs['cache_memcache']['servers'][]=array("host"=>"127.0.0.1","port"=>"11211");
$configs['cache_memcache']['servers'][]=array("host"=>"","port"=>"");
$configs['cache_memcache']['servers'][]=array("host"=>"","port"=>"");

/**
 * user can define which source to use for cache - sqlite/mysql/memcache
 */
$configs['cache_source'] = ""; //or mysql or memcache

/**
 * which urls are allowed in url, user can specify that. for example if u want to allow white space, just add \s in the following regex 
 * pattern
 */
$configs['allowed_url_chars'] = "/[^@%A-z0-9\/\.\^]/";


/* DB */
/**
 * database specific configurations
 */

/**
 * if set to true, orchid loads the necessary database drivers before executing the scripts.
 */
$configs['db']['usedb']="";

/**
 * you can have multiple database configuration stored as states, like $configs['db']['test'] for test environment, or
 * $configs['db']['production'] for production environment. now you can switch quickly to these states by specifying which 
 * configuratioon to use. if you set 'state' to 'test', only test configuration will be loaded.
 */
$configs['db']['state']="development";
$configs['db']['production']['dbname']="";
$configs['db']['production']['dbhost']="";
$configs['db']['production']['dbuser']="";
$configs['db']['production']['dbpwd']="";
$configs['db']['production']['persistent']=""; //true of fale to allow persistency
$configs['db']['production']['dbtype']="";

$configs['db']['test']['dbname']="";
$configs['db']['test']['dbhost']="";
$configs['db']['test']['dbuser']="";
$configs['db']['test']['dbpwd']="";
$configs['db']['test']['persistent']=""; //true or false, to allow persistency
$configs['db']['test']['dbtype']="";

$configs['db']['development']['dbname']="test";
$configs['db']['development']['dbhost']="localhost";
$configs['db']['development']['dbuser']="root";
$configs['db']['development']['dbpwd']="root1234";
$configs['db']['development']['persistent']=true;
$configs['db']['development']['dbtype']="mysql";

/**
 * if set to true, orchid will use database based sessions for session management. and in that case you have to create the following
 * sessions table in your database 
 * CREATE TABLE `sessions` (
	`id` varchar(32) NOT NULL,
	`access` int(10) default NULL,
	`data` text,
	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1
 *
 */
$configs['use_session_db']=false;

/**
 * specify the name of the table to consider for storing session data, for example "sessions"
 */
$configs['session_table']=null;

/**
 * if enabled, orchid will delivered the rendered output after gzip conmpression to browser. almost all modern browsers suppor
 * gzip compressed content
 */
$configs['js_gzip_enabled']=false;

/**
 * default character encoding to use for rendering outputs, by default it is set as utf-8 or unicode. 
 */
$configs['char_encoding'] = "utf-8";

/**
 * if set to true, orchid will call session_start() at the beginning of execution of any action
 */
$configs['session_auto_start'] = false;

/**
 * catch all controller is a default controller which will get the control if user request to an non-existing controller. for example
 * you can specify name of any controller as catch all controller and when there is a 404 controller request from users, the catch all
 * controller will be invoked
 */
$configs['catch_all_controller'] = "";

/**
 * like catch all controller, you can specify any action as catch all action. so when user request a 404-action, this action 
 * will be invoked with all the parameters.
 */
$configs['catch_all_action'] = "";

/**
 * base url where orchid is hosted, with a trailing slash
 */
$configs['base_url']=str_replace("/index.php","",$_SERVER['PHP_SELF'])."";
$configs['base_url']="http://122.248.7.196/hasin/orchidframework";

/**
 * if you are developing facebook apps with orchid, use this parameter to store your facebook application name
 */
$configs['facebook_app_name'] = "App Name";

/**
 * facebook application api key
 */
$configs['facebook_api_key'] = "App API Key";

/**
 * facebook application secret key
 */
$configs['facebook_secret_key'] = "App Secret Key";

/**
 * facebook application url, with a trailing slash at the end
 */
$configs['facebook_app_url'] = "App facebook url, with trailing slash";

/**
 * callback url of your facebook application, with a trailing slash at the end
 */
$configs['facebook_callback_url'] = "App Callback Url - with trailing slash";

?>
