<?php
include_once '../globals.php';

includeModel("slogan");
includeModel("sliderPhrase");
includeModel("leaderReward");

//$temp = new slogan('a','b');
$slogan = slogan::getSlogan('DefCamp');

$temp1 = new sliderPhrase('a','b');
$sliderPhrase= $temp1->getSliderPhrase('DefCamp');

$temp2 = new leaderReward('1','b','a','d',10);
$leaderReward= $temp2->getleaderReward('DefCamp');
var_dump($slogan);

$GLOBALS["page_title"] = "CatBee Landing Page";
$GLOBALS["title"] = $slogan->firstLine;
$GLOBALS["subtitle"] = $slogan->secondLine;

catbeeLayoutComp($layout, "inputforms/landing",$sliderPhrase);

echo "DOCUMENT ROOT: ".$_SERVER['DOCUMENT_ROOT'];
echo "</p>";
var_dump($layout);
catbeeLayout($layout, 'landing');
?>