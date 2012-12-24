<?php

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

        DbManager::insertOnly("campfriendlanding", $names, $values);
    }
    public function GetFriendLanding($campaign)
    {

        $rows = DbManager::selectValues("SELECT F.id, F.slogan, F.friendMessage,
          F.rewardMessage1, F.rewardMessage2 FROM friendlanding F
                       INNER JOIN campfriendlanding cf on F.Id = cf.FriendLandingID
                       WHERE cf.campaignId=?",
            array(new DbParameter($campaign->id,PDO::PARAM_INT)));
        $Friendlandings = array();
        foreach ($rows as $row)
        {
            $FriendLanding = new FriendLanding();
            $FriendLanding->id = $row['id'];
            $FriendLanding->slogan = $row['slogan'];
            $FriendLanding->friendMessage = $row['friendMessage'];
            $FriendLanding->rewardMessage1 = $row['rewardMessage1'];
            $FriendLanding->rewardMessage2 = $row['rewardMessage2'];
            array_push($Friendlandings, $FriendLanding);
        }
        $campaign->friendLandings = $Friendlandings;
    }

    public function insertFriendLandings($campaign)
    {
        foreach ($campaign->friendLandings as $friendLanding)
        {
            $this->insertFriendLanding($campaign, $friendLanding);
        }
    }
}
