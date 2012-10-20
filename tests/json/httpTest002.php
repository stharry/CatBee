<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestUtils.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/components/rest/RestLogger.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/3dParty/facebook/facebook.php");

RestLogger::log("Start");

$facebook = new Facebook(array(
    'appId' => '369374193139831',
    'secret' => '894b434b7da7bca8c5549e6e5584581f',
    'cookie' => false
));

$facebook->setAccessToken('AAAFP8aGSQHcBAMppDZCgPVJITouNgZBNnLm8RLWFB0p0JHSqqkjSk2210SAGhtaql9UncT112YygVI2E6vePssMoVtkXzRssdKQGpn2AZDZD');

$kuku = $facebook->api('/me/friends/');

RestLogger::log("after friends");

RestLogger::log($facebook->getLastUrl());

$restUtils = new RestUtils();
$restUtils->sendResponse(0, json_encode($kuku));
exit;

