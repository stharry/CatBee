<?php

include_once $_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php";

$page = isset($_GET["page"]) ? $_GET["page"] : 'goDeal.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CatBee Demo</title>

    <link rel="stylesheet" type="text/css" media="all" href="/CatBee/public/res/css/jquery.fancybox.css?reload">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js?reload"></script>


    <link rel="stylesheet" type="text/css" media="all" href="res/index.css?reload">
    <script type="text/javascript" src="http://127.0.0.1:8080/CatBee/adapters/installs/catbeeframe.js"></script>

    <?php if ($page == 'goDeal.php'){?>
    <script type="text/javascript" src="http://127.0.0.1:8080/CatBee/adapters/installs/Embedded_FanForToys.js?reload"></script>
    <?php }; ?>

</head>
<body onload="">

<a id="autostart" href="/CatBee/adapters/demo/demoActions/<?php echo  $GLOBALS["page"] ?>" ></a>

<?php if ($page != 'goDeal.php'){?>
<script type="text/javascript">jQuery(document).ready(function() {
    $("#autostart").trigger('click');
});</script>
    <?php }; ?>

</body>
</html>