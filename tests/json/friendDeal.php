<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$friendDealTemplate = json_decode(file_get_contents("res/friendDeal.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $friendDealTemplate);
