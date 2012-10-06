<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Reward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LandingReward.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonRewardAdapter implements IModelAdapter
{
    private function singleRewardToArray($reward)
    {
        return
            array("value" => $reward->value,
                "code" => $reward->code,
                "type" => $reward->type,
                "description" => $reward->description,
                "typeDescription" => $reward->typeDescription);

    }

    public function toArray($obj)
    {
        $landingRewardsProps = array();

        foreach ($obj as $landingReward)
        {
            $singleRewardProps = array(
                "leaderReward" => $this->singleRewardToArray($landingReward->leaderReward),
                "friendReward" => $this->singleRewardToArray($landingReward->friendReward)
            );
            array_push($landingRewardsProps, $singleRewardProps);
        }

        return $landingRewardsProps;
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
        $reward->typeDescription = $rewardProps["typeDescription"];

        return$reward;
    }
}
