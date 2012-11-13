<?php

class JsonLandingRewardAdapter implements IModelAdapter
{
    private $singleRewardAdapter;

    function __construct()
    {
        $this->singleRewardAdapter = new JsonSingleRewardAdapter();
    }

    private function rewardFromArray($rewardProps)
    {
        return $this->singleRewardAdapter->fromArray($rewardProps);
    }

    private function singleRewardToArray($reward)
    {
        return $this->singleRewardAdapter->toArray($reward);
    }

    public function toArray($obj)
    {
            $singleRewardProps = array(
                'id' => $obj->id,
                "leaderReward" => $this->singleRewardToArray($obj->leaderReward),
                "friendReward" => $this->singleRewardToArray($obj->friendReward));

            return $singleRewardProps;
    }

    public function fromArray($obj)
    {
        $landingReward = new LandingReward();

        $landingReward->leaderReward = $this->rewardFromArray($obj[ "leaderReward" ]);
        $landingReward->friendReward = $this->rewardFromArray($obj[ "friendReward" ]);
        $landingReward->id = $obj[ 'id' ];

        return $landingReward;
    }
}
