<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/components/IFriendLStrategy.php");

class DefaultFriendLStrategy implements chooseFriendLanding
{

    public function chooseFriendLanding($campaign, $order)
    {
        return $campaign->FriendLandings[0];
    }
}
