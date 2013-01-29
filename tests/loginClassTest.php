<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$url = 'https://api-ssl.bitly.com/v3/shorten?' .
    'access_token=57973b2f6a137f2c5f0f4d1b852032c2d3993bcd&longUrl=' .
    urlencode('http://127.0.0.1:8080/CatBee');

echo $url;

echo '</p>';

require_once('Timer.php');
$timer = new Benchmark_Timer();
$timer->start();

for ($i = 0; $i < 2; $i++)
{
    $ch = curl_init();

// Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $content = trim(curl_exec($ch));

    $curlError = curl_error($ch);

    echo $curlError;

    curl_close($ch);
    echo $content;
}
$timer->stop();
$timer->display();

//
//$response = RestUtils::sendAnyRequest($url, null);
//
//var_dump($response);