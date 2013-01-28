<?php

include_once $_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php";

$params = isset($_GET['sid']) ? '?sid='.$_GET['sid'] : '';
$page = isset($_GET["page"]) ? $_GET["page"] : 'goDeal.php';
$page = $page.$params;

RestLogger::log("demo adapter home.php redirected to the ", $page);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CatBee Demo</title>

    <link rel="stylesheet" type="text/css" media="all" href="/CatBee/public/res/css/jquery.fancybox.css?reload">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js?reload"></script>

    <script src="res/guiders-1.2.8.js"> </script>

    <link rel="stylesheet" type="text/css" media="all" href="res/guiders-1.2.8.css?reload">
    <link rel="stylesheet" type="text/css" media="all" href="res/home.css?reload">

    <script type="text/javascript" src="/CatBee/adapters/Installs/catbeeframe.js"></script>
    <script type="text/javascript" src="/CatBee/adapters/Installs/catbeewelcome.js?reload"></script>

</head>
<body

<a
        id="autostart"
        href="/CatBee/adapters/demo/demoActions/goWelcome.php?sid=<?php echo  $_GET['sid'] ?>"

        ></a>

<script type="text/javascript">jQuery(document).ready(function() {
    $("#autostart").trigger('click');
});</script>

</body>
</html>