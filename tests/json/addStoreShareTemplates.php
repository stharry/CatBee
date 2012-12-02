<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$dir = $GLOBALS[ "dirBase" ] . '/tests/json/res/add*ShareTemplate.json';

foreach (glob($dir) as $ff)
{
    echo $ff;
    $shareTemplate = json_decode(file_get_contents($ff));

    $restUtils = new RestUtils();
    $restUtils->SendPostRequest("share", "", $shareTemplate);

    echo "Add ".basename($ff)." - OK </p>";
}