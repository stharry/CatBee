<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $GLOBALS["page_title"] ?></title>
		<link href="<?= $GLOBALS["rootPath"] ?>res/css/base.css" rel="stylesheet" type="text/css"/>
    	<link href="<?= $GLOBALS["rootPath"] ?>res/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
    	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    	<script src="<?= $GLOBALS["rootPath"] ?>res/js/landing.js"></script>
	</head>
	<body>
		<div class="pnlBox" style="margin-top: 100px;padding:20px;">
			<h2 class="title"><?php echo $GLOBALS["title"] ?></h2>
			<h4 class="title"><?php echo $GLOBALS["subtitle"] ?></h4>
			<hr>
			<?php
				catbeeRender($p);
			?>
		</div>
	</body>
</html>