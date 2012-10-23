<?php
include_once 'globals.php';

includeModel("FriendLanding");

$friendLanding = new friendLanding();
$friendLanding->slogan ="Get off any purchase at FunForToys.com";
$friendLanding->friendMessage ="Crafted You a Great Deal";
$friendLanding->rewardMessage1 ="Here is Your Promotion Code";
$friendLanding->rewardMessage2 ="Just Apply it on Checkout";

catbeeLayoutComp($layout, "friendLanding", $friendLanding);
catbeeLayout($layout, 'friendLanding');


//catbeeLayoutComp($layout, "test/test", array("asi" => "lalala"));
//catbeeLayoutComp($layout, "test/test", array("asi" => "bababaab"));
//catbeeLayout($layout, 'default');
?>