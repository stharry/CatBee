<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$order = json_decode(file_get_contents("CTTPushDeal.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $order);
