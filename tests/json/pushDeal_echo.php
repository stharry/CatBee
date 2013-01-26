<html>
 <header>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
 </header>
<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

require_once('Timer.php');
$timer = new Benchmark_Timer();
$timer->start();

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
IncludeComponent('rest', 'RestUtils');

$order = json_decode(file_get_contents("res/pushDeal.json"));

ob_start();

$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $order);

$timer->stop();
//$timer->display();

$body = ob_get_contents();
ob_end_clean();

file_put_contents('C:/Program Files (x86)/EasyPHP-12.1/www/CatBee/log/kaka.html', $body);

echo 1;
?>

<body>
<script type="text/javascript" language="javascript">

    $(function(){

        $('<div id="modalDiv" style="height: 700px;"></div>').appendTo('body');

        $('#modalDiv').load('http://127.0.0.1:8080/CatBee/log/kaka.html');

           });
</script>
</body>
</html>