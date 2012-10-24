<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$campaign = json_decode(file_get_contents("res/pushCampaign.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("campaign", "", $campaign);

echo "Push campaign - OK </p>";