<?php

include('../../components/rest/RestUtils.php');
//    foreach (glob("../model/*.php") as $filename){    include $filename;}


$order = array("order" => array(
    "amount" => 76.00,
    "id" => 123,
    "purchases" => array(
        "purchase" => array(
            "itemcode" => "123456789",
            "url" => "...",
            "price" => "76.00",
            "description" => ""
        )
    ),
    "customer" => array(
        "email" => "spidernah@gmail.com",
        "firstName" => "Vadim",
        "lastName" => "Regev",
        "nickName" => "spidernah"
    ),
    "store" => array(
        "authCode" => "19FB6C0C-3943-44D0-A40F-3DC401CB3703",
    ),
    "render" => array(
        "popup" => true
    )
));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("land", "", $order);

