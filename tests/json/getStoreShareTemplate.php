<?php

include('../../components/rest/RestUtils.php');

$shareFilter = json_decode(file_get_contents("getStoreShareTemplate.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("share", "", $shareFilter);

echo "THE END";