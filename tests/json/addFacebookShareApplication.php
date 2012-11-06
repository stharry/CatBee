<?php

    include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
    IncludeComponent('rest', 'RestUtils');

    $shareTemplate = json_decode(file_get_contents("res/addFacebookShareApplication.json"));


    $restUtils = new RestUtils();
    $restUtils->SendPostRequest("share", "", $shareTemplate);

    echo "Add facebook share application - OK </p>";
