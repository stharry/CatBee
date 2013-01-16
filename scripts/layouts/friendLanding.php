<!DOCTYPE html>
<html>
<head>
    <title>CatBee Friend Landing Page</title>
    <meta http-equiv="Cache-control" content="no-cache">
    <title><?php echo $GLOBALS["page_title"] ?></title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script src="<?php echo  $GLOBALS[ "rootPath" ] ?>/res/js/jcookie.js?reload" type="text/javascript"></script>

    <script src="<?php echo  $GLOBALS[ "rootPath" ] ?>/res/js/TribZi.js?reload" type="text/javascript"></script>
    <script language="javascript">TribZi.initFriendDeal(<?php echo $p[0]['params'][2]; ?>);</script>

    <script src="<?php echo  $GLOBALS[ "catBeePath" ].'adapters/installs/shops/'.$p[0]['params'][1]->shopId.'/js/' ?>friendLanding.js?reload" type="text/javascript"></script>

    <!--Landing common rendering-->
    <link href="<?php echo  $GLOBALS["rootPath"] ?>/res/css/friendLanding.css?reload" rel="stylesheet" type="text/css"/>

</head>
<body>
<div class="box-wrapper">
    <div class="box box-shadow rounded-corners friend-landing" >
        <div  class="separator">
            <div class="inner-box-content-2 rounded-corners clearfix">
                <div class="product-pic"><img class="rounded-corners" id="productImage" alt="" /></div>
                <?php
                catbeeRender($p);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>