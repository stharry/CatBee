<?php

interface IFriendLandingDao
{
    public function insertFriendLanding($campaign, $FriendLanding);
    public function insertFriendLandings($campaign);
    public function GetFriendLanding($campaign);
}
