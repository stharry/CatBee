<?php

class PdoLeaderLandingRewardDao implements ILeaderLandingRewardDao
{

    public function getLeaderLandingRewards($leaderLanding)
    {
        $rows = DbManager::selectValues(" SELECT lr.LandingId, l.id leaderId,
        l.RewardDesc leaderDescription,
        l.value leaderValue, l.type leaderType, l.code leaderCode,
        f.id friendId, f.RewardDesc friendDescription,
        f.value friendValue, f.type friendType, f.code friendCode,
        f.RewardTypeDesc friendRewardTypeDesc,
        l.RewardTypeDesc leaderRewardTypeDesc
         FROM landingReward lr
          INNER JOIN reward l ON lr.LeaderReward = l.id
           INNER JOIN reward f ON lr.FriendReward = f.id
            WHERE lr.LandingId = ?",
        array($leaderLanding->id => PDO::PARAM_INT));

        $landingRewards = array();

        foreach ($rows as $row)
        {
            $landingReward = new LandingReward();
            $landingReward->id = $row["LandingId"];

            $landingReward->leaderReward = new Reward();
            $landingReward->leaderReward->id = $row["leaderId"];

            $landingReward->leaderReward->description = $row["leaderDescription"];
            $landingReward->leaderReward->value = $row["friendValue"];
            $landingReward->leaderReward->type = $row["friendType"];
            $landingReward->leaderReward->code = $row["friendCode"];
            $landingReward->leaderReward->typeDescription = $row["friendRewardTypeDesc"];

            $landingReward->friendReward = new Reward();
            $landingReward->friendReward->id = $row["friendId"];

            $landingReward->friendReward->description = $row["friendDescription"];
            $landingReward->friendReward->value = $row["leaderValue"];
            $landingReward->friendReward->type = $row["leaderType"];
            $landingReward->friendReward->code = $row["leaderCode"];
            $landingReward->friendReward->typeDescription = $row["leaderRewardTypeDesc"];

            array_push($landingRewards, $landingReward);

        }
        $leaderLanding->landingRewards = $landingRewards;
    }

    public function insertLeaderLandingRewards($leaderLanding)
    {
        foreach ($leaderLanding->landingRewards as $landingReward)
        {
            $this->insertReward($landingReward->leaderReward);
            $this->insertReward($landingReward->friendReward);

            $this->mapRewardsToLanding($leaderLanding, $landingReward);
        }
    }

    private function mapRewardsToLanding($leaderLanding, $landingReward)
    {
        $names = array("landingId",
            "leaderReward", "friendReward");

        $values = array($leaderLanding->id,
            $landingReward->leaderReward->id,
            $landingReward->friendReward->id);

        $landingReward->id = DbManager::insertAndReturnId("landingReward",
            $names, $values);
    }

    private function insertReward($reward)
    {
        $names = array("RewardDesc", "value", "type", "code", "RewardTypeDesc");
        $values = array($reward->description, $reward->value,
            $reward->type, $reward->code, $reward->typeDescription);

        $reward->id = DbManager::insertAndReturnId("reward", $names, $values);
    }

    public function updateLeaderLanding($leaderLanding)
    {
        // TODO: Implement updateLeaderLanding() method.
    }
}
