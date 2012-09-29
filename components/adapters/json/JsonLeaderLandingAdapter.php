<?php

include_once("JsonRewardAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LeaderLanding.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonLeaderLandingAdapter implements IModelAdapter
{
    private $jsonRewardAdapter;

    private function singleLandingToArray($landing)
    {
        return
            array("firstSloganLine" => $landing->firstSloganLine,
                "secondSloganLine" => $landing->secondSloganLine,
                "firstSliderLine" => $landing->firstSliderLine,
                "secondSliderLine" => $landing->secondSliderLine,
                "landingRewards" => $this->jsonRewardAdapter->toArray($landing->landingRewards));

    }

    function __construct()
    {
        $this->jsonRewardAdapter = new JsonRewardAdapter();
    }

    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $landingsProps = array();

            foreach ($obj as $landing)
            {
                array_push($landingsProps, $this->singleLandingToArray($landing));
            }
            return $landingsProps;
        }
        return $this->singleLandingToArray($obj);
    }

    public function fromArray($obj)
    {
        $landings = array();


        foreach ($obj as $landingProps)
        {
            $landing = new LeaderLanding();

            $landing->firstSloganLine = $landingProps["firstSloganLine"];
            $landing->secondSloganLine = $landingProps["secondSloganLine"];
            $landing->firstSliderLine = $landingProps["firstSliderLine"];
            $landing->secondSliderLine = $landingProps["secondSliderLine"];

            $landing->landingRewards = $this->jsonRewardAdapter->fromArray($landingProps["landingRewards"]);

            array_push($landings, $landing);
        }

        return $landings;
    }
}
