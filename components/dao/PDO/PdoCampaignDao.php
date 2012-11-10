<?php

class PdoCampaignDao implements ICampaignDao
{

    private $leaderLandingDao;
    private $FriendLandingDao;


    function __construct($leaderLandingDao,$FriendLandingDao)
    {
        $this->leaderLandingDao = $leaderLandingDao;
        $this->FriendLandingDao = $FriendLandingDao;
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
        $selectParam = "";
        //TO DO- This Should be Changed so the Join will be on the What is now the StoreBranch
        $selectClause = "SELECT c.id, c.name, c.description,c.store  FROM campaign c
                    INNER JOIN storebranch s
                    ON c.store = s.shopid";
        if($campaignFilter->storeID == null)
        {
            $selectClause = $selectClause." WHERE   c.id = ?";
            $selectParam = $campaignFilter->CampID;
        }
        else
        {
            $selectClause = $selectClause." WHERE s.shopid = ?";
            $selectParam = $campaignFilter->storeID;

        }
        $rows = DbManager::selectValues($selectClause,
           array($selectParam => PDO::PARAM_STR));


        $campaigns = array();

        foreach ($rows as $row)
        {
            $campaign = new Campaign();
            $campaign->id = $row["id"];
            $campaign->name = $row["name"];
            $campaign->description = $row["description"];
            //TODO - The Store should be a full object here
            $campaign->store =$row["store"];
            //TODO - dont think the following 2 calls should be here... can we take them above to the
            //Todo - yes, you right - need to move it campaign manager
            If(!$campaignFilter->lazy)
            {
                $this->leaderLandingDao->getLeaderLandings($campaign);
                $this->FriendLandingDao->GetFriendLanding($campaign);
            }
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
