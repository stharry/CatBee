<?php

include_once("../../model/dao/ILeaderLandingRewardDao.php");
include_once("../DbManager.php");

class PdoLeaderLandingRewardDao implements ILeaderLandingRewardDao
{

    public function getLeaderLandingRewards($leaderLanding)
    {
        // TODO: Implement getLeaderLandingRewards() method.
    }

    public function insertLeaderLandingRewards($leaderLanding)
    {
        foreach ($leaderLanding->landingRewards as $landingReward)
        {
            $this->insertReward($landingReward->leaderReward);
            $this->insertReward($landingReward->friendReward);

            $this->mapRewardsToLanding($landingReward);
        }
    }

    private function mapRewardsToLanding($landingReward)
    {
        $names = array("LeaderReward", "FriendReward");
        $values = array($landingReward->leaderReward->id, $landingReward->friendReward->id);

        $landingReward->id = DbManager::insertAndReturnId("landingReward",
            $names, $values);
    }

    private function insertReward($reward)
    {
        $names = array("description", "value", "type", "code");
        $values = array($reward->description, $reward->value,
            $reward->type, $reward->code);

        $reward->id = DbManager::insertAndReturnId("reward", $names, $values);
    }

    public function updateLeaderLanding($leaderLanding)
    {
        // TODO: Implement updateLeaderLanding() method.
    }
}
