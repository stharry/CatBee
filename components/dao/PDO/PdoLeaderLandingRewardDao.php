<?php

class PdoLeaderLandingRewardDao implements ILeaderLandingRewardDao
{

    private function fillLandingReward($landingReward, $row)
    {
        $landingReward->id = $row["id"];
        $landingReward->landingId = $row["landingId"];

        $landingReward->leaderReward = new Reward();
        $landingReward->leaderReward->id = $row["leaderId"];

        $landingReward->leaderReward->description = $row["leaderDescription"];
        $landingReward->leaderReward->value = $row["leaderValue"];
        $landingReward->leaderReward->type = $row["leaderType"];
        $landingReward->leaderReward->code = $row["leaderCode"];
        $landingReward->leaderReward->typeDescription = $row["leaderRewardTypeDesc"];

        $landingReward->friendReward = new Reward();
        $landingReward->friendReward->id = $row["friendId"];

        $landingReward->friendReward->description = $row["friendDescription"];
        $landingReward->friendReward->value = $row["friendValue"];
        $landingReward->friendReward->type = $row["friendType"];
        $landingReward->friendReward->code = $row["friendCode"];
        $landingReward->friendReward->typeDescription = $row["friendRewardTypeDesc"];

    }

    private function getLandingRewardSelect()
    {
        return " SELECT lr.id, lr.LandingId, l.id leaderId,
        l.RewardDesc leaderDescription,
        l.value leaderValue, l.type leaderType, l.code leaderCode,
        f.id friendId, f.RewardDesc friendDescription,
        f.value friendValue, f.type friendType, f.code friendCode,
        f.RewardTypeDesc friendRewardTypeDesc,
        l.RewardTypeDesc leaderRewardTypeDesc
         FROM landingReward lr
          INNER JOIN reward l ON lr.LeaderReward = l.id
           INNER JOIN reward f ON lr.FriendReward = f.id";
    }

    public function getLeaderLandingRewards($leaderLanding)
    {
        $rows = DbManager::selectValues($this->getLandingRewardSelect()
            ." WHERE lr.LandingId = ?
                ORDER BY lr.RewardIndex ",
            array(new DbParameter($leaderLanding->id,PDO::PARAM_INT)));


        $landingRewards = array();

        foreach ($rows as $row)
        {
            $landingReward = new LandingReward();

            $this->fillLandingReward($landingReward, $row);
            array_push($landingRewards, $landingReward);

        }
        $leaderLanding->landingRewards = $landingRewards;
    }

    public function insertLeaderLandingRewards($leaderLanding)
    {
        $index = 1;
        foreach ($leaderLanding->landingRewards as $landingReward)
        {
            $this->insertReward($landingReward->leaderReward);
            $this->insertReward($landingReward->friendReward);

            $this->mapRewardsToLanding($leaderLanding, $landingReward, $index);
            $index++;
        }
    }

    private function mapRewardsToLanding($leaderLanding, $landingReward, $index)
    {
        $names = array("landingId", "leaderReward",
            "friendReward", "RewardIndex");

        $values = array($leaderLanding->id,
            $landingReward->leaderReward->id,
            $landingReward->friendReward->id,
            $index);

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

    public function fillLandingRewardById($landingReward)
    {
        $rows = DbManager::selectValues($this->getLandingRewardSelect()
            ." WHERE lr.id = ? ",
            array(new DbParameter($landingReward->id,PDO::PARAM_INT)));

        if (!$rows)
        {
            RestLogger::log('PdoLeaderLandingRewardDao::fillLandingRewardById no such reward');
            return;
        }


        $this->fillLandingReward($landingReward, $rows[0]);
    }
}
