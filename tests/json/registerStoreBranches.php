<?php
echo 1;
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');
echo 2;
$campaign = json_decode(file_get_contents("res/registerStoreBranches.json"));
echo 3;
$restUtils = new RestUtils();
$restUtils->SendPostRequest("store", "", $campaign);

echo "Create Stores - OK \n";