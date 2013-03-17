<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();

$filter = json_decode(file_get_contents("res/GetTribeByFilter.json"));
$tribe = json_decode($restUtils->SendPostRequestAndReturnResult("tribe", "", $filter), true);
var_dump($tribe);


