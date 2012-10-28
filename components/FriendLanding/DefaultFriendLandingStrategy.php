<?php

class DefaultFriendLandingStrategy implements IFriendLandingStrategy
{

    public function chooseFriendLanding($campaign, $order)
    {
        return $campaign->FriendLandings[0];
    }
}
