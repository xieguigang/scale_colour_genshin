<?php

ini_set('session.cookie_lifetime',"86400‬");
ini_set('session.gc_maxlifetime', "86400‬"); 
ini_set('memory_limit', "1024M");
ini_set('max_input_time', 3600);
ini_set('max_execution_time', 3600);
ini_set('post_max_size', "4096M");
ini_set('upload_max_filesize', "4096M");

session_start();

include __DIR__ . "/php.NET/package.php";
include __DIR__ . "/access.php";
include __DIR__ . "/framework.php";
include __DIR__ . "/baidu_map.php";

define("WWWROOT", realpath(__DIR__ . "/.././"));

dotnet::AutoLoad(__DIR__ . "/config.ini.php");
dotnet::HandleRequest(new App(), new accessController());
