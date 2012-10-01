<?php

include('../../components/rest/RestUtils.php');

$shareTemplate = json_decode(file_get_contents("addStoreShareTemplate.json"));

//var_dump($campaign);

//$restUtils = new RestUtils();
//$restUtils->SendPostRequest("campaign", "", $campaign);

$restUtils = new RestUtils();
$restUtils->SendPostRequest("share", "", $shareTemplate);

echo "THE END";