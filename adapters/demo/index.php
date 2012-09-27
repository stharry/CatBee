<?php

include_once $_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CatBee Demo</title>

    <link rel="stylesheet" type="text/css" media="all" href="/CatBee/public/res/css/jquery.fancybox.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script src="/CatBee/public/res/js/jquery.fancybox.js"></script>
    <script src="res/demoAdapter.js"></script>

</head>
<body
        background="res/PostPurchasePageForDemo.jpg"
        onload="$('#autostart').trigger('click');"
        >
<a
        id="autostart"
        href="http://127.0.0.1:8887/CatBee/adapters/demo/goDeal.php"
        ></a>
</body>
</html>