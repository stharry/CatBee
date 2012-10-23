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
            $FriendlandingsProps = array();

            foreach ($obj as $Friendlanding)
            {
                array_push($FriendlandingsProps, $this->singleFriendLandingToArray($Friendlanding));
            }
            return $FriendlandingsProps;
        }
        return $this->singleFriendLandingToArray($obj);
    }

    public function fromArray($obj)
    {

        $Friendlandings = array();
        foreach ($obj as $FriendlandingsProps)
        {
            $FriendLanding = new FriendLanding();
            $FriendLanding->slogan = $FriendlandingsProps["slogan"];
            $FriendLanding->friendMessage = $FriendlandingsProps["friendMessage"];
            $FriendLanding->rewardMessage1 = $FriendlandingsProps["rewardMessage1"];
            $FriendLanding->rewardMessage2 = $FriendlandingsProps["rewardMessage2"];

            array_push($Friendlandings, $FriendLanding);
        }
        return $Friendlandings;
    }
}
