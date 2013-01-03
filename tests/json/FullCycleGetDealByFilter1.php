<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();

////Push Deal 1  Customer Tomer@tribzi.com ,Date Y
//
//$order1 = json_decode(file_get_contents("res/DealByFilter/pushDeal1.json"));
//$restUtils->SendPostRequest("deal", "", $order1);
//
////Push Deal 2  Customer X ,Date z
//
//$order2 = json_decode(file_get_contents("res/DealByFilter/pushDeal2.json"));
//$restUtils->SendPostRequest("deal", "", $order2);
//
////Push Deal 3  Customer X Date Historical (one year Back)
//
//$order3 = json_decode(file_get_contents("res/DealByFilter/pushDeal3.json"));
//$restUtils->SendPostRequest("deal", "", $order3);
//
////Push Deal 4 Customer X Future Date
//$order4 = json_decode(file_get_contents("res/DealByFilter/pushDeal4.json"));
//$restUtils->SendPostRequest("deal", "", $order4);


//Share Deal 1 Via FB
$share = json_decode(file_get_contents("res/DealByFilter/shareStoreShareFacebook.json"));

$response = $restUtils->SendPostRequest("deal", "", $share);
//Share Deal Via Mail

//Push Deal 5 referring deal 1 for customer Z
//Open Deal 2 to record the Impression

//Get Deals By the Filter: Dates,FB
//Check Results including Impressions

