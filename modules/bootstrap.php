<?php

session_start();

include __DIR__ . "/php.NET/package.php";
include __DIR__ . "/access.php";
include __DIR__ . "/framework.php";
include __DIR__ . "/baidu_map.php";

define("WWWROOT", realpath(__DIR__ . "/.././"));

dotnet::AutoLoad(__DIR__ . "/config.ini.php");
dotnet::HandleRequest(new App(), new accessController());
