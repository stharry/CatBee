<?php

include('../../components/rest/RestUtils.php');

$campaign = json_decode(file_get_contents("res/pushCampaign.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("campaign", "", $campaign);

echo "THE END";