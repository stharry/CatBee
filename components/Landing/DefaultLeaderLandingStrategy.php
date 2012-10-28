<?php

class DefaultLeaderLandingStrategy implements ILeaderLandingStrategy
{

    public function chooseLeaderLanding($campaign, $order)
    {
        return $campaign->landings[0];
    }
}
