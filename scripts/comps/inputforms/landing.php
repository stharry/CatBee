<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once "C:/Program Files/EasyPHP-12.1/www/CatBee/scripts/models/slogan.php";
include_once "C:/Program Files/EasyPHP-12.1/www/CatBee/scripts/models/sliderPhrase.php";
include_once "C:/Program Files/EasyPHP-12.1/www/CatBee/scripts/models/leaderReward.php";

?>
Hey <?php echo $p["fname"]; ?><br />
<form>
    <!--
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.8/dijit/themes/claro/claro.css">
-->


<br/>

<?php
$temp = new slogan('a','b');
$slogan = $temp->getSlogan('DefulatStore');
echo $slogan->firstLine;echo "<br />";
echo $slogan->secondLine;
echo "<br />";

$temp1 = new sliderPhrase('a','b');
$sliderPhrase= $temp1->getSliderPhrase('DefulatStore');
echo $sliderPhrase->firstLine;echo "<br />";
echo $sliderPhrase->secondLine;
echo "<br />";

$temp2 = new leaderReward('1','b','a','d');
$leaderReward= $temp2->getleaderReward('DefulatStore');
//echo $leaderReward->low;
//echo "<br />";echo "<br />";echo "<br />";
include_once  'slider.php';
?>

<label for="LeaderReward">You get</label><input type="text" value="10"  id="LeaderReward"/><br/>

<label for="FriendReward">Your friends get</label><input type="text" value="10" id="FriendReward"/>



<script>

document.getElementById("CatBeeSlider").onchange=function(){UpdateDeal()};

function UpdateLeaderRewardDefultValue()
{
	
	document.getElementById("CatBeeSlider")
}
function UpdateDeal()
{
	//if (document.getElementById("CatBeeSlider").value=1) 
	//{} 
	//if{};
}
</script>
<?php
$header['From'] = "tomer.harry@gmail.com>"; 

$header['Subject'] = "test";

//$smtp = Mail::factory('smtp',

   //   array ('host' => $GLOBALS["smtphost"],

    //  'port' => $GLOBALS["smtpport"],

     // 'auth' => false));

$header['To'] = "tomer.harry@gmail.com>"; 

//$mail = $smtp->send($header['To'], $header, "Tomer");
 
 ?>

</form>
