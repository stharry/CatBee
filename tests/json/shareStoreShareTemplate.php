<?php
echo "share via Tribzi started...";
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$share = json_decode(file_get_contents("res/shareStoreShareTemplate.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("deal", "", $share);

echo "share via Tribzi - OK \n";