<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LeaderLanding.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/dao/ILeaderLandingDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/DbManager.php");

class PdoLeaderLandingDao implements ILeaderLandingDao
{
    private $leaderLandingRewardDao;

    function __construct($leaderLandingRewardDao)
    {
        $this->leaderLandingRewardDao = $leaderLandingRewardDao;

    }

    public function getLeaderLandings($campaign)
    {
        $rows = DbManager::selectValues("SELECT l.id, l.sloganFirst, l.sloganSecond,
          l.sliderFirst, l.sliderSecond FROM landing l
                       INNER JOIN CampaignLandings cl on l.Id = cl.landingId
                       WHERE cl.campaignId=?",
            array($campaign->id => PDO::PARAM_STR));

        $landings = array();

        foreach ($rows as $row)
        {
            $leaderLanding = new LeaderLanding();
            $leaderLanding->id = $row["id"];
            $leaderLanding->firstSloganLine = $row["sloganFirst"];
            $leaderLanding->secondSloganLine = $row["sloganSecond"];
            $leaderLanding->firstSliderLine = $row["sliderFirst"];
            $leaderLanding->secondSliderLine = $row["sliderSecond"];

            $this->leaderLandingRewardDao->getLeaderLandingRewards($leaderLanding);

            array_push($landings, $leaderLanding);
        }

        $campaign->landings = $landings;
    }

    public function insertLeaderLanding($campaign, $leaderLanding)
    {
        $names = array("sloganFirst", "sloganSecond", "sliderFirst", "sliderSecond");
        $values = array($leaderLanding->firstSloganLine,$leaderLanding->secondSloganLine,$leaderLanding->firstSliderLine,$leaderLanding->secondSliderLine);
        $leaderLanding->id = DbManager::insertAndReturnId("landing", $names, $values);

        $names = array("campaignId", "landingId");
        $values = array($campaign->id, $leaderLanding->id);

        DbManager::insert("CampaignLandings", $names, $values);

        $this->leaderLandingRewardDao->insertLeaderLandingRewards($leaderLanding);
    }

    public function updateLeaderLanding($leaderLanding)
    {
        // TODO: Implement updateLeaderLanding() method.
    }
}
