<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/dao/ILeaderLandingRewardDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LandingReward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Reward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/DbManager.php");

class PdoLeaderLandingRewardDao implements ILeaderLandingRewardDao
{

    public function getLeaderLandingRewards($leaderLanding)
    {
        $rows = DbManager::selectValues(" SELECT lr.LandingId, l.id leaderId, l.description leaderDescription,
        l.value leaderValue, l.type leaderType, l.code leaderCode, f.id friendId, f.description friendDescription,
        f.value friendValue, f.type friendType, f.code friendCode
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

            $landingReward->friendReward = new Reward();
            $landingReward->friendReward->id = $row["friendId"];

            $landingReward->friendReward->description = $row["friendDescription"];
            $landingReward->friendReward->value = $row["leaderValue"];
            $landingReward->friendReward->type = $row["leaderType"];
            $landingReward->friendReward->code = $row["leaderCode"];

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
