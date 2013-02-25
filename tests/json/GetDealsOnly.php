<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
$restUtils = new RestUtils();


$ResultsFilter = json_decode(file_get_contents("res/DealByFilter/GetCycleResults.json"));

$ResultsDeals = $restUtils->SendPostRequestAndReturnResult("deal", "", $ResultsFilter);

echo "Result deals </p>";
echo $ResultsDeals;
//Check Results including Impressions

