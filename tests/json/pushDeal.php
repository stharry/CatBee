<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$order = json_decode(file_get_contents("res/pushDeal.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $order);
