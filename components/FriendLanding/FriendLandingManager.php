<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/PDO/PdoFriendLandingDao.php");


class FriendLandingManager
{
    private $FriendLandingDao;

    function __construct()
    {
        $this->FriendLandingDao = new PdoFriendLandingDao();
    }

    public function SaveFriendLandingManager($campaign)
    {
        foreach ($campaign->friendLandings as $friend)
        {
             $this->FriendLandingDao->insertFriendLanding($campaign, $friend);
        }

    }
    public function showFriendLanding($friendLanding,$leaderDeal)
    {
        catbeeLayoutComp($layout, "friendLanding", $friendLanding[0]);
        //catbeeLayoutComp($layout, "FriendLanding", $leaderDeal);
        catbeeLayout($layout, 'friendLanding');


    }
}
