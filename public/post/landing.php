<?php
include_once '../globals.php';

includeModel("slogan");
includeModel("sliderPhrase");
includeModel("leaderReward");

$temp = new slogan('a','b');
$slogan = $temp->getSlogan('DefulatStore');

$temp1 = new sliderPhrase('a','b');
$sliderPhrase= $temp1->getSliderPhrase('DefulatStore');

$temp2 = new leaderReward('1','b','a','d');
$leaderReward= $temp2->getleaderReward('DefulatStore');
//var_dump($slogan);
$GLOBALS["page_title"] = "CatBee Landing Page";
$GLOBALS["title"] = $slogan->firstLine;
$GLOBALS["subtitle"] = $slogan->secondLine;
catbeeLayoutComp($layout, "inputforms/landing",$sliderPhrase);
catbeeLayout($layout, 'landing');
?>