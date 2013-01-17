<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$friendDealTemplate = json_decode(file_get_contents("res/friendDeal.json"));

//I need To retrieve the ActiveSHareID of the Default and build the Friend Deal Json like in GoWelcome

$restUtils = new RestUtils();

$temp = json_decode($restUtils->SendPostRequestAndReturnResult("deal", "", $friendDealTemplate), true);

$friendDeal = array('action'=>'friend Deal',
    'context' => array(
        'share' => array('context' => array('uid' =>  $temp[0]['leads'][0]['uid']))));

$restUtils->SendPostRequest("deal", "", $friendDeal);



