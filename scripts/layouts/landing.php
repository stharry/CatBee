<!DOCTYPE html>
<html>
<head>
    <!--Todo Ask Ais about js caching-->
    <meta http-equiv="Cache-control" content="no-cache">
    <title><?php echo $GLOBALS[ "page_title" ] ?></title>

    <!--Landing common rendering-->
    <link href="<?php echo $GLOBALS[ "rootPath" ] ?>res/css/jquery-ui.css?reload" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $GLOBALS[ "rootPath" ] ?>res/css/style.css?reload" rel="stylesheet" type="text/css"/>
    <!--email rendering-->

	<!--[if IE 7]>
		<style type="text/css">
			#slider{ margin-top: 10px;}
			#friendArea{
				top : 62px;
				right: 3px;
			}
			#leaderArea{
				top: 62px;
				left: 22px;
			}
		</style>
	<![endif]-->
	<!--[if IE 8]>
		<style type="text/css">
			.ui-slider-horizontal .ui-slider-handle{
				margin-left: -15px;
			}
		</style>
	<![endif]-->
	<!--[if IE 9]>
		<style type="text/css">
			.ui-slider-horizontal .ui-slider-handle{
				
			}
		</style>
	<![endif]-->
	<!--[if IE]>
		<style type="text/css">
			#slider-blue-content{
				left: 0px;
			}
			#share_list li a{
				width: 131px;
				height: 37px;
			}
			
		</style>
	<![endif]-->
	
    <link rel="stylesheet" type="text/css" media="all"
          href="<?php echo $GLOBALS[ "rootPath" ] ?>res/css/emailForm.css?reload">
    <link rel="stylesheet" type="text/css" media="all"
          href="<?php echo $GLOBALS[ "rootPath" ] ?>res/css/tweetForm.css?reload">

    <!--Landing common scripts-->

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/min/jquery.min.js"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/min/jquery-ui.min.js"></script>

<!--	<script type="text/javascript" src="https://api.cloudsponge.com/address_books.js"></script>-->
<!--	<script type="text/javascript" charset="utf-8">-->
<!--		var csPageOptions = {-->
<!--			domain_key:"RFULLDSNJ8E62YBDLS7S",-->
<!--			textarea_id:"mail-input"-->
<!--		};-->
<!--	</script>-->

    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/dev/chain-dev.js?v=1" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/dev/load-dev.js?v=1" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/mutate.events.js?v=1" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/mutate.min.js?v=1" type="text/javascript"></script>
<!--
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/min/json2.js?v=1" type="text/javascript"></script>
-->
    <script src="<?php echo $GLOBALS[ "rootPath" ] ?>res/js/min/easyXDM.js?v=1" type="text/javascript"></script>
    <script type="text/javascript">
        easyXDM.DomHelper.requiresJSON("<?php echo $GLOBALS[ "rootPath" ] ?>res/js/min/json2.js");
    </script>

    <script src="http://connect.facebook.net/en_US/all.js"></script>

    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>jcookie.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>TribZi.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script language="javascript">TribZi.init(<?php echo $p[0]['params'][1]; ?>);</script>
<!--    <script src="--><?//= $GLOBALS[ "rootPath" ] ?><!--/res/js/CatBee.js?reload" type="text/javascript"></script>-->
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>landing.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>pinterest.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>email.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>facebook.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>
    <script src="<?php echo $GLOBALS[ "rootJsPath" ] ?>twitter.js<?php echo $GLOBALS[ "catBeeJsVersion" ] ?>" type="text/javascript"></script>

    <!--email scripts
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
</head>
<body>
<div class="box-wrapper">
	<!--
		Remove rounded corners
	-->
    <div class="box"><!-- box-shadow -->
        <div class="box-title">
            <div class="inner-box">
                <div class="box-header">
                    <?php
					/*
					<h2 class="title"><?php echo $GLOBALS[ "leaderDeal" ]->landing->firstSloganLine ?></h2>
                    <h4 class="title"><?php echo $GLOBALS[ "leaderDeal" ]->landing->secondSloganLine ?></h4>
					*/
					?>
					<ul>
						<li class="slogan-text">
							<h3>Play</h3>
							<p>the slider</p>
						</li>
						<li class="plus"><span>+</span></li>
						<li class="slogan-text">
							<h3>Share</h3>
							<p>with your Tribe</p>
						</li>
						<li class="plus"><span>+</span></li>
						<li class="slogan-text">
							<h3>Enjoy</h3>
							<p>great rewards</p>
						</li>
					</ul>
                </div>
            </div>
        </div>
        <?php catbeeRender($p); ?>
    </div>
</div>
<script type="text/javascript">
    setTimeout(function(){var a=document.createElement("script");
        var b=document.getElementsByTagName("script")[0];
        a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0014/1321.js?"+Math.floor(new Date().getTime()/3600000);
        a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>
</body>
</html>