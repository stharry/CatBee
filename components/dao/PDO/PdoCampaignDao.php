<?php

class PdoCampaignDao implements ICampaignDao
{

    private $leaderLandingDao;
    private $FriendLandingDao;


    function __construct($leaderLandingDao,$FriendLandingDao)
    {
        $this->leaderLandingDao = $leaderLandingDao;
        $this->FriendLandingDao = $FriendLandingDao;

        RestLogger::log("PdoCampaignDao created...");
    }

    public function isCampaignExists($campaign)
    {
        $rows = DbManager::selectValues("SELECT id FROM campaign WHERE code=?",
            array(new DbParameter($campaign->code,PDO::PARAM_STR)));

        if (!isset($rows)) {
            return false;
        }
        $campaign->id = $rows[0]['id'];

        return true;
    }

    public function getCampaigns($campaignFilter)
    {
        RestLogger::log('PdoCampaignDao::getCampaigns begin', $campaignFilter);

        $selectParam  = new DbParameter(null,PDO::PARAM_INT);
        //TO DO- This Should be Changed so the Join will be on the What is now the StoreBranch
        $selectClause = "SELECT c.id, c.code, c.description,c.store
              FROM campaign c
                    INNER JOIN storebranch s
                    ON c.store = s.id ";

        if ($campaignFilter->campId)
        {
            $selectClause = $selectClause." WHERE c.id = ?";
            $selectParam->paramValue = $campaignFilter->campId;

        }
        else if ($campaignFilter->code)
        {
            $selectClause = $selectClause." WHERE c.code = ?";
            $selectParam->paramValue = $campaignFilter->code;

        }
        else if ($campaignFilter->store)
        {
            $selectClause = $selectClause." WHERE s.id = ?";
            $selectParam->paramValue = $campaignFilter->store->id;

        }
        $rows = DbManager::selectValues($selectClause,
           array($selectParam));


        $campaigns = array();

        foreach ($rows as $row)
        {
            $campaign = new Campaign();
            $campaign->id = $row["id"];
            $campaign->code = $row["code"];
            $campaign->description = $row["description"];
            //TODO - The Store should be a full object here
            $storeBranch = new StoreBranch();
            $storeBranch->id = $row["store"];
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
        $names = array("store", "code", "description");
        $values = array($campaign->store->id, $campaign->code,
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
        $sql = "UPDATE campaign SET desc=:desc  WHERE store=:store AND code=:code";

        $params = array(':store' => $campaign->store,
            ':code' => $campaign->code,
            ':desc' => $campaign->description);

        DbManager::updateValues($sql, $params);
    }
}
