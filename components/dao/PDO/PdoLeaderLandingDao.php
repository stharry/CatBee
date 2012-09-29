<?php

include_once("../../model/LeaderLanding.php");
include_once("../../model/dao/ILeaderLandingDao.php");
include_once("../DbManager.php");

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
                       INNER JOIN CampaignLandings cl on l.campaignId = cl.campaignId
                       WHERE cl.campaignId=?",
            array($campaign->id => PDO::PARAM_STR));

        $landings = array();

        foreach ($rows as $row)
        {
            $leaderLanding = new LeaderLanding();
            $leaderLanding->id = $row[0];
            $leaderLanding->firstSloganLine = $row[1];
            $leaderLanding->secondSloganLine = $row[2];
            $leaderLanding->firstSliderLine = $row[3];
            $leaderLanding->secondSliderLine = $row[4];

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
