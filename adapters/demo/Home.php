<?php

include_once $_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php";

$params = 'pdl='.$_GET["pdl"].'&rwd='.$_GET["rwd"];
$page = isset($_GET["page"]) ? $_GET["page"] : 'goDeal.php';
$page = $page.'?'.$params;

RestLogger::log("demo adapter home.php redirected to the ", $page);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CatBee Demo</title>

    <link rel="stylesheet" type="text/css" media="all" href="/CatBee/public/res/css/jquery.fancybox.css?reload">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js?reload"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js?reload"></script>
    <script src="/CatBee/public/res/js/jquery.fancybox.js?reload"></script>
    <script src="res/demoHomeAdapter.js?reload"></script>
    <link rel="stylesheet" type="text/css" media="all" href="res/home.css?reload">

</head>
<body

<a
        id="autostart"
        href="/CatBee/adapters/demo/demoActions/<?= $GLOBALS["page"] ?>"

        >Click to create awesome deal</a>


</body>
</html>