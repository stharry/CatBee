<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");

$restUtils = new RestUtils();
$response = $restUtils->SendFreePostRequest('http://127.0.0.1:8080/CatBee/tests/json/httpTest002.php', array());

echo "</p>response:</p>";

var_dump($response);

echo "THE END";
