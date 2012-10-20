<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/3dParty/facebook/facebook.php");

$shareNode = json_decode(file_get_contents("res/getFacebookContacts.json"));

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("share", "", $shareNode);

var_dump($response);
echo "THE END";