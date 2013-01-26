<?php
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();

$filter = json_decode(file_get_contents("res/GetDealsByFullFilter.json"));
$deals = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $filter), true);

$order = json_decode(file_get_contents("res/pushReferredDeal.json"), true);
$order['context']['successfulReferral'] = $deals[0]['leads'][0]['uid'];

if (!$order['context']['successfulReferral'])
{
    throw new Exception('Cannot get active share uid');
}

$restUtils->SendPostRequest("deal", "", $order);

$filter = json_decode(file_get_contents("res/GetDealsByFullFilter.json"));
$restUtils = new RestUtils();
$deals = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $filter), true);

if (!$deals[0]['leads'][0]['orders'][0])
{
    throw new Exception('Cannot get successful referrals');
}
