<?php
include_once '../globals.php';

includeModel("slogan");
includeModel("sliderPhrase");
includeModel("leaderReward");

//$temp = new slogan('a','b');
$slogan = slogan::getSlogan('DefCamp');

//temp vad todo: remove it
$slogan->firstLine = "You got the power!!!";
$slogan->secondLine = "Create an Awesome Deal";

$temp1 = new sliderPhrase('a','b');
$sliderPhrase= $temp1->getSliderPhrase('DefCamp');

$temp2 = new leaderReward('1','b','a','d',10);
$leaderReward= $temp2->getleaderReward('DefCamp');

$GLOBALS["page_title"] = "CatBee Landing Page";
$GLOBALS["title"] = $slogan->firstLine;
$GLOBALS["subtitle"] = $slogan->secondLine;

catbeeLayoutComp($layout, "inputforms/landing",$sliderPhrase);

catbeeLayout($layout, 'landing');
?>