<?php

include('../../components/rest/RestUtils.php');

$share = json_decode(file_get_contents("res/shareStoreShareTemplate.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("share", "", $share);

echo "THE END";