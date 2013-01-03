<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponents('rest');

$shareId = $_GET['sid'];

    $friendDeal = array('action'=>'friend Deal',
    'context' => array(
    'share' => array('context' => array('uid' => $shareId))));

RestLogger::log("goWelcome params ", $friendDeal);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $friendDeal);

