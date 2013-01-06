<?php

    include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
    IncludeComponent('rest', 'RestUtils');

$dir = $GLOBALS[ "dirBase" ] . '/tests/json/res/add*ShareApplication.json';

foreach (glob($dir) as $ff)
{
    echo $ff;
    $shareTemplate = json_decode(file_get_contents($ff));

    $restUtils = new RestUtils();
    $restUtils->SendPostRequest("share", "", $shareTemplate);

    echo "Add ".basename($ff)." - OK </p>";
}
