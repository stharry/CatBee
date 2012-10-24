<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/friendLanding.php");

class JsonFriendLandingAdapter implements IModelAdapter
{

    private function singleFriendLandingToArray($Friendlanding)
    {
        return
            array("slogan" => $Friendlanding->slogan,
                "friendMessage" => $Friendlanding->friendMessage,
                "rewardMessage1" => $Friendlanding->rewardMessage1,
                "rewardMessage2" => $Friendlanding->rewardMessage2);
    }

    function __construct()
    {
    }

    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $friendLandingsProps = array();

            foreach ($obj as $Friendlanding)
            {
                array_push($friendLandingsProps, $this->singleFriendLandingToArray($Friendlanding));
            }
            return $friendLandingsProps;
        }
        return $this->singleFriendLandingToArray($obj);
    }

    public function fromArray($obj)
    {

        $friendLandings = array();
        foreach ($obj as $friendLandingsProps)
        {
            $FriendLanding = new FriendLanding();
            $FriendLanding->slogan = $friendLandingsProps["slogan"];
            $FriendLanding->friendMessage = $friendLandingsProps["friendMessage"];
            $FriendLanding->rewardMessage1 = $friendLandingsProps["rewardMessage1"];
            $FriendLanding->rewardMessage2 = $friendLandingsProps["rewardMessage2"];

            array_push($friendLandings, $FriendLanding);
        }
        return $friendLandings;
    }
}
