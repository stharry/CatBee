<?php


include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponents('rest');

$dealId = isset($_GET['pdl']) ? $_GET['pdl'] : '1';
$rewardId = isset($_GET['rwd']) ? $_GET['rwd'] : '1';

    $friendDeal = array('action'=>'friend Deal',
    'context' => array("parentDealId" => $dealId,
    'reward' => array('id' => $rewardId)));

RestLogger::log("goWelcome params ", $friendDeal);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $friendDeal);

