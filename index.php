<?php
/**
 * orchid bootstrap file. used internally to process request and dispatch
 * with the help of router and dispatcher.
 * 
 * @author 		Hasin Hayder [http://hasin.wordpress.com]
 * @copyright 	New BSD License
 * @version 	0.1	
 */
include("core/ini.php");
initializer::initialize();
$router = loader::load("router");
dispatcher::dispatch($router);
?>