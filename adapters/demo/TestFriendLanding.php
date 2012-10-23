<?php

include('../../components/rest/RestUtils.php');
$FriendLanding = json_decode(file_get_contents("res/demoFriendLanding.json"));
$restUtils = new RestUtils();
$restUtils->SendPostRequest("deal", "", $FriendLanding);
