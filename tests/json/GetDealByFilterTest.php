<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$kuku = $restUtils->SendFreePostRequest("https://api-ssl.bitly.com/oauth/access_token", "");
var_dump($kuku);
exit;

$customer = json_decode(file_get_contents("res/GetDealsByFullFilter.json"));
$restUtils = new RestUtils();
$deals = $restUtils->SendPostRequestAndReturnResult("deal", "", $customer);



var_dump($deals);