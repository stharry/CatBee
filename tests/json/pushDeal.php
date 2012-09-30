<?php

include_once('../../components/rest/RestUtils.php');

$order = json_decode(file_get_contents("pushDeal.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $order);
