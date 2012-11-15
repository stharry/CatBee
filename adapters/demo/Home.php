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
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js?reload"></script>
    <script src="res/guiders-1.2.8.js"> </script>
    <script src="/CatBee/public/res/js/jquery.fancybox.js?reload"></script>
    <script src="res/demoHomeAdapter.js?reload"></script>
    <link rel="stylesheet" type="text/css" media="all" href="res/guiders-1.2.8.css?reload">
    <link rel="stylesheet" type="text/css" media="all" href="res/home.css?reload">

</head>
<body

<a
        id="autostart"
        href="/CatBee/adapters/demo/demoActions/<?= $GLOBALS["page"] ?>"

        >Click to create awesome deal</a>
<div id="Homefake" style="position:absolute;left:900px;top:200px;"> </div>
<p> <script type="text/javascript">
    var guider_note = {
        id: "first",
        attachTo: "#Homefake",
        buttons: [
            {
                name: "Next",
                onclick: function(){window.location='/CatBee/adapters/demo/HomeAutoStart.php';}
            }
        ],
        description: "The referred friend will be instructed how to Redeem the Reward",
        position: 12,
        overlay: false,
        title: "Friend Welcome landing page",
        width: 400
    };
    initialize = function() {
        guiders.createGuider(guider_note).show();
    };
    $(document).ready(initialize);
</script></p>


</body>
</html>