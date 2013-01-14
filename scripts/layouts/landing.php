<?php
try
{
    $dealAdapter = new JsonLeaderDealAdapter();
    $dealProps   = $dealAdapter->toArray($GLOBALS[ "leaderDeal" ]);
    $dealJson    = json_encode($dealProps);
} catch (Exception $e)
{
    RestLogger::log("EXCEPTION", $e);
}
?>

<!DOCTYPE html>
<html>
<head>
    <!--Todo Ask Ais about js caching-->
    <meta http-equiv="Cache-control" content="no-cache">
    <title><?php echo $GLOBALS[ "page_title" ] ?></title>

    <!--Landing common rendering-->
    <link href="<?php echo $GLOBALS[ "rootPath" ] ?>/res/css/jquery-ui.css?reload" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $GLOBALS[ "rootPath" ] ?>/res/css/style.css?reload" rel="stylesheet" type="text/css"/>
    <!--email rendering-->

    <link rel="stylesheet" type="text/css" media="all"
          href="<?php echo $GLOBALS[ "rootPath" ] ?>/res/css/emailForm.css?reload">
    <link rel="stylesheet" type="text/css" media="all"
          href="<?php echo $GLOBALS[ "rootPath" ] ?>/res/css/tweetForm.css?reload">


    <link rel="stylesheet" type="text/css" media="all"
          href="<?php echo $GLOBALS[ "rootPath" ] ?>/res/css/jquery.fancybox.css?reload">

    <!--Landing common scripts-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/dev/chain-dev.js?v=1" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/dev/load-dev.js?v=1" type="text/javascript"></script>

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/jquery.fancybox.js?reload" type="text/javascript"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/jcookie.js?reload" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/TribZi.js?reload" type="text/javascript"></script>
    <script language="javascript">TribZi.init(<?php echo $dealJson; ?>);</script>
<!--    <script src="--><?//= $GLOBALS[ "rootPath" ] ?><!--/res/js/CatBee.js?reload" type="text/javascript"></script>-->

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/landing.js?reload" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/email.js?reload" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/facebook.js?reload" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>/res/js/twitter.js?reload" type="text/javascript"></script>

    <!--email scripts
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
</head>
<body>
<div class="box-wrapper">
    <div class="box box-shadow rounded-corners">
        <div class="box-title rounded-top">
            <div class="inner-box rounded-top">
                <div class="box-header rounded-top">
                    <h2 class="title"><?php echo $GLOBALS[ "leaderDeal" ]->landing->firstSloganLine ?></h2>
                    <h4 class="title"><?php echo $GLOBALS[ "leaderDeal" ]->landing->secondSloganLine ?></h4>
                </div>
            </div>
        </div>
        <?php
        catbeeRender($p);
        ?>
    </div>
</div>
</body>
</html>