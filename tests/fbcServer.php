<?php

$parameters = array(
    'app_id' => '369374193139831',
    'link' => 'http://www.tribzi.com/',
    'picture' => 'http://www.medfordmailboxshop.com/Merchant/Images_Product/Box/Wood/198-wood-train-L.jpg',
    'name' => 'Hi, I shared a great deal for you...:)',
    'caption' => 'TribZi Deal',
    'display' => 'popup',
    'redirect_uri' => 'http://127.0.0.1:8080/CatBee/components/share/facebook/facebookLogin.php'

);
$url = 'http://www.facebook.com/dialog/send?'.http_build_query($parameters);

echo "<script>blah = window.open('".$url."')</script>";