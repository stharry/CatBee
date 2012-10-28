<?php

class JsonRewardAdapter implements IModelAdapter
{
    private $singleRewardAdapter;

    function __construct()
    {
        $this->singleRewardAdapter = new JsonSingleRewardAdapter();
    }

    private function singleRewardToArray($reward)
    {
        return $this->singleRewardAdapter->toArray($reward);
    }

    public function toArray($obj)
    {
        $landingRewardsProps = array();

        foreach ($obj as $landingReward) {
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

        foreach ($obj as $landingRewardProps) {
            $landingReward = new LandingReward();

            $landingReward->leaderReward = $this->rewardFromArray($landingRewardProps["leaderReward"]);
            $landingReward->friendReward = $this->rewardFromArray($landingRewardProps["friendReward"]);

            array_push($landingRewards, $landingReward);
        }

        return $landingRewards;
    }

    private function rewardFromArray($rewardProps)
    {
        return $this->singleRewardAdapter->fromArray($rewardProps);
    }
}
