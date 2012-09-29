<?php

include_once("../../model/Campaign.php");
include_once("../../model/dao/ICampaignDao.php");
include_once("../DbManager.php");

class PdoCampaignDao implements ICampaignDao
{

    private $leaderLandingDao;

    function __construct($leaderLandingDao)
    {
        $this->leaderLandingDao = $leaderLandingDao;
    }

    public function isCampaignExists($campaign)
    {
        $rows = DbManager::selectValues("SELECT id FROM campaign WHERE store=? AND name=?",
            array($campaign->store => PDO::PARAM_STR, $campaign->name, PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $campaign->id = $rows[0][0];

        return true;
    }

    public function getCampaigns($store)
    {
        $rows = DbManager::selectValues("SELECT id, name, description  FROM campaign WHERE store=?",
            array($store->id => PDO::PARAM_STR));

        $campaigns = array();

        foreach ($rows as $row)
        {
            $campaign = new Campaign();
            $campaign->id = $row[0];
            $campaign->name = $row[1];
            $campaign->description = $row[2];

            array_push($campaigns, $campaign);
        }
        return $campaigns;
    }

    public function insertCampaign($campaign)
    {
        $names = array("store", "name", "description");
        $values = array($campaign->store->id, $campaign->name,
            $campaign->description);

        $campaign->id = DbManager::insertAndReturnId("campaign", $names, $values);

        foreach ($campaign->landings as $leaderLanding)
        {
            $this->leaderLandingDao->insertLeaderLanding($campaign, $leaderLanding);
        }
    }

    public function updateCampaign($campaign)
    {
        $sql = "UPDATE campaign SET desc=:desc  WHERE store=:store AND name=:name)";

        $params = array(':store' => $campaign->store,
            ':name' => $campaign->name,
            ':desc' => $campaign->description);

        $campaign->id = DbManager::updateValues($sql, $params);
    }
}
