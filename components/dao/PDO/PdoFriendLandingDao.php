<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/FriendLanding.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/dao/IFriendLandingDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/DbManager.php");

class PdoFriendLandingDao implements IFriendLandingDao
{
    function __construct()
    {
    }
    public function insertFriendLanding($campaign, $FriendsLanding)
    {
        $names = array("slogan", "friendMessage", "rewardMessage1", "rewardMessage2");
        $values = array($FriendsLanding->slogan,$FriendsLanding->friendMessage,$FriendsLanding->rewardMessage1,$FriendsLanding->rewardMessage2);
        $FriendsLanding->id = DbManager::insertAndReturnId("Friendlanding", $names, $values);
        //Tomer - TODO - need to seperate this function to a different function/Interface
        $names = array("campaignId", "FriendlandingID");
        $values = array($campaign->id, $FriendsLanding->id);

        DbManager::insert("campfriendlanding", $names, $values);
    }
}
