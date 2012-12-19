<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
echo 1;
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
echo 2;
include_once('Serializers.php');
echo 3;
echo "</p> order adapter 1000 times:";

require_once('Timer.php');
$timer = new Benchmark_Timer();
$timer->start();


$orderProps = json_decode(file_get_contents("res/pushDeal.json"), true)['context'];

for ($testNo = 0; $testNo < 1000; $testNo++)
{
    $adapter = new JsonOrderAdapter();
    $adapter->fromArray($orderProps);
}
$timer->stop();
$timer->display();

echo 10;
$loader = new ClassPropertiesConfig();
$loader->LoadClassInfos($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/tests/json/classDefinitions");

$orderProps = json_decode(file_get_contents("res/pushDeal.json"), true)['context'];

$serializer = new ClassSerializer($loader->getMap());

echo "</p> serializer 1000 times:";

$timer->start();
for ($testNo = 0; $testNo < 1000; $testNo++)
{
    $order = $serializer->deserialize($orderProps, 'Order');
}
$timer->stop();
$timer->display();

echo 100;
$orderProps = $serializer->serialize($order, 'Order');

echo json_encode($orderProps);
echo "</p>";
var_dump($order);
