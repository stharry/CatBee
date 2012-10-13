<?php

include_once('../../components/rest/RestUtils.php');

$friendDealTemplate = json_decode(file_get_contents("res/friendDeal.json"));

echo http_build_query($friendDealTemplate);
echo "</p>---";

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $friendDealTemplate);
