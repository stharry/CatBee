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
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js?reload"></script>
    <script src="res/guiders-1.2.8.js"> </script>
    <script src="/CatBee/public/res/js/jquery.fancybox.js?reload"></script>
    <script src="res/demoAdapter.js?reload"></script>
    <link rel="stylesheet" type="text/css" media="all" href="res/index.css?reload">
    <link rel="stylesheet" type="text/css" media="all" href="res/guiders-1.2.8.css?reload">

</head>
<body

<div id="fake" style="position:absolute;left:900px;top:250px;"> </div>
<p> <script type="text/javascript">
    var guider_note = {
        id: "first",
        attachTo: "#fake",
        buttons: [
            {
                name: "Next",
                onclick: function(){window.location='/CatBee/adapters/demo/AutoStart.php';}
            }
        ],
        description: "Great! You have just made another sale on your site.</BR> Now, why not use the power of word of mouth recommendations and have your customer spread the word about your great website?</BR> How can you do that?</BR> Click on the Next button to see how fun and easy it is!",
        position: 12,
        overlay: false,
        title: "CatBee Slider Post Purchase Demo",
        width: 400
    };
    initialize = function() {
        guiders.createGuider(guider_note).show();
    };
    $(document).ready(initialize);
</script></p>
</body>
</html>