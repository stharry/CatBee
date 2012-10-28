<?php

//var_dump($_SERVER);
//var_dump($GLOBALS);

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php");
include('../../components/rest/RestUtils.php');

$campaignFilter = json_decode(file_get_contents("res/getCampaigns.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("campaign", "", $campaignFilter);

echo "THE END";