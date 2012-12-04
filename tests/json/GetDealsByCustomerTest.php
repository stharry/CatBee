<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$customer = json_decode(file_get_contents("res/GetDealsByCustomer.json"));
$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $customer);