<!DOCTYPE html>
<html>
	<head>
        <!--Todo Ask Ais about js caching-->
        <meta http-equiv="Cache-control" content="no-cache">
		<title><?php echo $GLOBALS["page_title"] ?></title>

        <!--Landing common rendering-->
    	<link href="<?= $GLOBALS["rootPath"] ?>/res/css/jquery-ui.css?reload" rel="stylesheet" type="text/css"/>
        <link href="<?= $GLOBALS["rootPath"] ?>/res/css/style.css?reload" rel="stylesheet" type="text/css"/>
        <!--email rendering-->

        <link rel="stylesheet" type="text/css" media="all" href="<?= $GLOBALS["rootPath"] ?>/res/css/emailForm.css?reload">


        <link rel="stylesheet" type="text/css" media="all" href="<?= $GLOBALS["rootPath"] ?>/res/css/jquery.fancybox.css?reload">

        <!--Landing common scripts-->

    	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

        <script src="<?= $GLOBALS["rootPath"] ?>/res/js/jquery.fancybox.js?reload" type="text/javascript"></script>

        <script src="<?= $GLOBALS["rootPath"] ?>/res/js/landing.js?reload" type="text/javascript"></script>
        <script src="<?= $GLOBALS["rootPath"] ?>/res/js/email.js?reload" type="text/javascript"></script>

                <!--email scripts
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
	</head>
	<body>
        <div class="box-wrapper">
                <div class="box box-shadow rounded-corners">
                    <div class="box-title rounded-top">
                        <div class="inner-box rounded-top">
                            <div class="box-header rounded-top">
			    <h2 class="title"><?php echo $GLOBALS["leaderDeal"]->landing->firstSloganLine ?></h2>
			    <h4 class="title"><?php echo $GLOBALS["leaderDeal"]->landing->secondSloganLine ?></h4>
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