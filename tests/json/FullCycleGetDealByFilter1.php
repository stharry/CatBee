<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();

//Push Deal 1  Customer Tomer@tribzi.com ,Date Y

$order1 = json_decode(file_get_contents("res/DealByFilter/pushDeal1.json"));
$restUtils->SendPostRequest("deal", "", $order1);
//
////Push Deal 2  Customer X ,Date z
//
$order2 = json_decode(file_get_contents("res/DealByFilter/pushDeal2.json"));
$restUtils->SendPostRequest("deal", "", $order2);
//
////Push Deal 3  Customer X Date Historical (one year Back)
//
$order3 = json_decode(file_get_contents("res/DealByFilter/pushDeal3.json"));
$restUtils->SendPostRequest("deal", "", $order3);
//
////Push Deal 4 Customer X Future Date
$order4 = json_decode(file_get_contents("res/DealByFilter/pushDeal4.json"));
$restUtils->SendPostRequest("deal", "", $order4);


//Share Deal 1 Via FB
$share = json_decode(file_get_contents("res/DealByFilter/shareStoreShareFacebook.json"));

$response = $restUtils->SendPostRequest("deal", "", $share);

//Share Deal 1 Via Mail

$shareEmail = json_decode(file_get_contents("res/DealByFilter/ShareStoreShareEmail.json"));

$response = $restUtils->SendPostRequest("deal", "", $shareEmail);

//Open Friend Deal For ShareVia FB of Deal 1


$friendDealTemplate = json_decode(file_get_contents("res/DealByFilter/friendDeal6.json"));
$temp = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $friendDealTemplate), true);

$friendDeal = array('action'=>'friend Deal',
    'context' => array(
        'share' => array('context' => array('uid' =>  $temp[0]['leads'][0]['uid']))));
$restUtils->SendPostRequest("deal", "", $friendDeal);

//log another Impression
$restUtils->SendPostRequest("deal", "", $friendDeal);


//Push Deal 5 referring deal 1 for customer Z share Via facebook

$filter = json_decode(file_get_contents("res/DealByFilter/GetPushDeal1.json"));

$deals = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $filter), true);
$order5 = json_decode(file_get_contents("res/DealByFilter/pushDeal5.json"),true);
$order5['context']['successfulReferral'] = $deals[0]['leads'][0]['uid'];
$restUtils->SendPostRequest("deal", "", $order5);
//

//Get Deals By the Filter: Dates,FB


$ResultsFilter = json_decode(file_get_contents("res/DealByFilter/GetCycleResults.json"));

$ResultsDeals = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $ResultsFilter), true);

var_dump ($ResultsDeals);
//Check Results including Impressions

