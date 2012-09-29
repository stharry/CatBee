<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/components/ILeaderLandingStrategy.php");

class DefaultLeaderLandingStrategy implements ILeaderLandingStrategy
{

    public function chooseStrategy($campaign, $order)
    {
        return $campaign->landings[0];
    }
}
