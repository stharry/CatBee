<?php
include_once '../globals.php';

includeModel("deal");
includeModel("landingFriend");
//($id, $leader,$leaderReward,$friendReward,$initDate)
$de = new deal('a','b','c','d','e');
$x = $de->GetDeal($_POST["deal"]);
if ($x==null)
{
    echo "Deal not found";
    die();
}
$lf = new landingFriend('1','1','1','1');
$y= $lf->GetlandingFriend($x->landingFriend);
echo $y->refSlogan;
//get the Deal and Accoring to the Deal retrive the landing Freind page

//$temp1 = new sliderPhrase('a','b');
//$sliderPhrase= $temp1->getSliderPhrase('DefCamp');

//$temp2 = new leaderReward('1','b','a','d',10);
//$leaderReward= $temp2->getleaderReward('DefCamp');
//var_dump($slogan);

//$GLOBALS["page_title"] = "CatBee Landing Page";
//$GLOBALS["title"] = $slogan->firstLine;
//$GLOBALS["subtitle"] = $slogan->secondLine;

//catbeeLayoutComp($layout, "inputforms/landing",$sliderPhrase);
//catbeeLayout($layout, 'landing');
?>