<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$shareTemplate = json_decode(file_get_contents("res/addStoreEmailShareTemplate.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("share", "", $shareTemplate);

echo "Add email template - OK </p>";