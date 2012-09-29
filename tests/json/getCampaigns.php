<?php

include('../../components/rest/RestUtils.php');

$campaignFilter = json_decode(file_get_contents("getCampaigns.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("campaign", "", $campaignFilter);

echo "THE END";