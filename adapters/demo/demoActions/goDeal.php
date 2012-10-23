<?php

include('../../../components/rest/RestUtils.php');
//    foreach (glob("../model/*.php") as $filename){    include $filename;}


$order = json_decode(file_get_contents("../res/demoDeal.json"));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $order);

