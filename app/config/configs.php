<?
$configs['use_layout']=true;
$configs['unit_test_enabled']=false;
$configs['default_controller']="welcome";
$configs['global_profile']=false;

/* DB */
$configs['db']['usedb']="mysql";
$configs['db']['development']['dbname']="test";
$configs['db']['development']['dbhost']="localhost";
$configs['db']['development']['dbuser']="root";
$configs['db']['development']['dbpwd']="root1234";
$configs['db']['development']['persistent']=true;
$configs['db']['development']['dbtype']="mysql";

$configs['use_session_db']=false;
$configs['session_table']="sessions";
$configs['css_dir']="styles";
$configs['google_map_api']="ABQIAAAAK49OOamo8inlPm0oVAsu5hT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQIcWTaKgysPazGPZPIbdbDZ5Jf1w";


$configs['base_url']=str_replace("/index.php","",$_SERVER['PHP_SELF'])."";
//$configs['base_url']="http://122.248.7.196/hasin/orchidframework";
$configs['char_encoding'] = "utf-8";
$configs['js_gzip_enabled'] = false;

$configs['session_auto_start'] = true;

$configs['catch_all_controller'] = "";
$configs['facebook_app_name'] = "App Name";
$configs['facebook_api_key'] = "App API Key";
$configs['facebook_secret_key'] = "App Secret Key";
$configs['facebook_app_url'] = "App facebook url, with trailing slash";
$configs['facebook_callback_url'] = "App Callback Url - with trailing slash";

?>
