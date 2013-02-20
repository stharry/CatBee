<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$cbClient = new CatBeeClient();
$cbClient->setServer('http://www.apid.tribzi.com');

$discounts = $cbClient->setShop('2', '')->getDiscounts('15ede00f-634a-11e2-a702-0008cae720a7');

var_dump($discounts);