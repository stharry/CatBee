<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/3dParty/facebook/facebook.php");

echo urlencode('http://127.0.0.1:8080/CatBee/api/deal/?action=friendDeal&context%5Bleader%5D%5Bemail%5D=vadim.chebyshev%40retalix.com&context%5Bfriend%5D%5Bemail%5D=Enter+your+friends+e-mail&context%5Breward%5D%5Bvalue%5D=10&context%5Breward%5D%5Bcode%5D=ABCD1234_10&context%5Breward%5D%5Btype%5D=coupon&context%5Bstore%5D%5BauthCode%5D=19FB6C0C-3943-44D0-A40F-3DC401CB3703');
return;
$shareNode = json_decode(file_get_contents("res/getFacebookContacts.json"));

$restUtils = new RestUtils();
$response = $restUtils->SendPostRequest("share", "", $shareNode);

var_dump($response);
echo "THE END";