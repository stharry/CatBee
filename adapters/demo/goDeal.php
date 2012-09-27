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
        "authCode" => "demo",
        "description" => "...",
        "url" => "..."
    ),
    "render" => array(
        "popup" => true
    )
));

$restUtils = new RestUtils();
$restUtils->SendPostRequest("land", "", $order);

