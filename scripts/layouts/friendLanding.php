<!DOCTYPE html>
<html>
<head>
    <title>CatBee Friend Landing Page</title>
    <meta http-equiv="Cache-control" content="no-cache">
    <title><?php echo $GLOBALS["page_title"] ?></title>

    <!--Landing common rendering-->
    <link href="<?= $GLOBALS["rootPath"] ?>/res/css/friendLanding.css?reload" rel="stylesheet" type="text/css"/>

</head>
<body>
<div class="box-wrapper">
    <div class="box box-shadow rounded-corners friend-landing" >
        <div  class="separator">
            <div class="inner-box-content-2 rounded-corners clearfix">
                <div class="product-pic"><img class="rounded-corners" src="<?= $GLOBALS["rootPath"] ?>/res/images/dummy_pic.png" alt="" /></div>
                <?php
                catbeeRender($p);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>