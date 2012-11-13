<?php

class JsonRewardAdapter implements IModelAdapter
{
    private $landingRewardAdapter;

    function __construct()
    {
        $this->landingRewardAdapter = new JsonLandingRewardAdapter();
    }

    public function toArray($obj)
    {
        $landingRewardsProps = array();

        foreach ($obj as $landingReward) {
            $singleRewardProps = $this->landingRewardAdapter->toArray($landingReward);
            array_push($landingRewardsProps, $singleRewardProps);
        }

        return $landingRewardsProps;
    }

    public function fromArray($obj)
    {
        $landingRewards = array();

        foreach ($obj as $landingRewardProps) {

            $landingReward = $this->landingRewardAdapter->fromArray($landingRewardProps);
            array_push($landingRewards, $landingReward);
        }

        return $landingRewards;
    }
}
