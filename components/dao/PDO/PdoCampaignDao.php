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
        RestLogger::log('PdoCampaignDao::getCampaigns begin', $campaignFilter);

        $selectParam = "";
        //TO DO- This Should be Changed so the Join will be on the What is now the StoreBranch
        $selectClause = "SELECT c.id, c.name, c.description,c.store,s.shopname,s.url
              FROM campaign c
                    INNER JOIN storebranch s
                    ON c.store = s.id ";
        if($campaignFilter->store == null)
        {
            $selectClause = $selectClause." WHERE c.id = ?";
            $selectParam = $campaignFilter->campId;
        }
        else
        {
            $selectClause = $selectClause." WHERE s.id = ?";
            $selectParam = $campaignFilter->store->id;

        }
        $rows = DbManager::selectValues($selectClause,
           array($selectParam => PDO::PARAM_INT));


        $campaigns = array();

        foreach ($rows as $row)
        {
            $campaign = new Campaign();
            $campaign->id = $row["id"];
            $campaign->name = $row["name"];
            $campaign->description = $row["description"];
            //TODO - The Store should be a full object here
            $storeBranch = new StoreBranch();
            $storeBranch->id = $row["store"];
            $storeBranch->shopName = $row["shopname"];
            $storeBranch->redirectUrl = $row["url"];
            $campaign->store = $storeBranch;
            If($campaignFilter->LoadLeaderLanding==true)
            {

                $this->leaderLandingDao->getLeaderLandings($campaign);

            }
            If($campaignFilter->LoadFriendLanding)
            {
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
        $sql = "UPDATE campaign SET desc=:desc  WHERE store=:store AND name=:name";

        $params = array(':store' => $campaign->store,
            ':name' => $campaign->name,
            ':desc' => $campaign->description);

        $campaign->id = DbManager::updateValues($sql, $params);
    }
}
