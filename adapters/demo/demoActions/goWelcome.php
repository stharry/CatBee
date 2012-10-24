<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponents('rest');

$dealId = isset($_REQUEST['id']) ? isset($_REQUEST['id']) : '1';

    $friendDeal = array('action'=>'friend Deal',
    'context' => array("parentDealId" => $dealId));

RestLogger::log("goWelcome params ", $friendDeal);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $friendDeal);

