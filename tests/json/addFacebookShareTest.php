<?php

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$params = array('post_id' => 123, 'pdl' => 1);
RestUtils::SendComponentRequest('share/facebook/facebookLogin.php', null, $params);

echo 'OK';