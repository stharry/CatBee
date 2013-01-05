<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$friendDealTemplate = json_decode(file_get_contents("res/friendDeal.json"));

//I need To retrieve the ActiveSHareID of the Default and build the Friend Deal Json like in GoWelcome

$restUtils = new RestUtils();

$temp = $restUtils->SendPostRequest("deal", "", $friendDealTemplate);

if($temp !=null)
    echo "5";


