<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Campaign.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/dao/ICampaignDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/DbManager.php");

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
            array($campaign->store => PDO::PARAM_INT,
                    $campaign->name => PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $campaign->id = $rows[0][0];

        return true;
    }

    public function getCampaigns($campaignFilter)
    {
        $rows = DbManager::selectValues("SELECT c.id, c.name, c.description  FROM campaign c
                    INNER JOIN store s
                    ON c.store = s.id WHERE s.authCode = ?",
            array($campaignFilter->storeCode => PDO::PARAM_STR));

        $campaigns = array();

        foreach ($rows as $row)
        {
            $campaign = new Campaign();
            $campaign->id = $row["id"];
            $campaign->name = $row["name"];
            $campaign->description = $row["description"];

            $this->leaderLandingDao->getLeaderLandings($campaign);

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
        //Tomer - I dont think it is good to Call from Dao To Dao, this part should be part of the Business logic
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
