<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Reward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LandingReward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonRewardAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $landingRewards = array();

        foreach ($obj as $landingRewardProps)
        {
            $landingReward = new LandingReward();

            $landingReward->leaderReward = $this->rewardFromArray($landingRewardProps["leaderReward"]);
            $landingReward->friendReward = $this->rewardFromArray($landingRewardProps["friendReward"]);

            array_push($landingRewards, $landingReward);
        }

        return $landingRewards;
    }

    private function rewardFromArray($rewardProps)
    {
        $reward = new Reward();

        $reward->value = $rewardProps["value"];
        $reward->code = $rewardProps["code"];
        $reward->type = $rewardProps["type"];
        $reward->description = $rewardProps["description"];

        return$reward;
    }
}
