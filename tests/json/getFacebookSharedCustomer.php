<?php

include('../../components/rest/RestUtils.php');

$campaignFilter = json_decode(file_get_contents("res/getFacebookSharedCustomer.json"));

//var_dump($campaign);

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("share", "", $campaignFilter);

echo "THE END";