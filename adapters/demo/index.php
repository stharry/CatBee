<?php

    include('../../components/rest/RestUtils.php');
//    foreach (glob("../model/*.php") as $filename){    include $filename;}

    if (isset($_COOKIE["deal"]))
    {

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
            )
        ));

        $restUtils = new RestUtils();
        $restUtils->SendPostRequest("land", "", $order);

        setcookie("deal" , '');
        return;
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CatBee Demo</title>

    <script>
        function load()
        {
            setTimeout(
                    function(){
                        document.cookie = "deal=go";
                            window.location="http://127.0.0.1:8887/CatBee/adapters/demo/index.php";
                        }, 1500);

        }
    </script>

</head>
<body background="res/PostPurchasePageForDemo.jpg" onload="load()">

</body>
</html>