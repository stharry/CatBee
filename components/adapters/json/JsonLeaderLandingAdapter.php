<?php

include_once("JsonRewardAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LeaderLanding.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonLeaderLandingAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $landings = array();
        $sonRewardAdapter = new JsonRewardAdapter();

        foreach ($obj as $landingProps)
        {
            $landing = new LeaderLanding();

            $landing->firstSloganLine = $landingProps["firstSloganLine"];
            $landing->secondSloganLine = $landingProps["secondSloganLine"];
            $landing->firstSliderLine = $landingProps["firstSliderLine"];
            $landing->secondSliderLine = $landingProps["secondSliderLine"];

            $landing->landingRewards = $sonRewardAdapter->fromArray($landingProps["landingRewards"]);

            array_push($landings, $landing);
        }

        return $landings;
    }
}
