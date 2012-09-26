<?php

class CampaignManager
{
    private function validateOrder($order)
    {
        return true;
    }

    private  function  getLeaderLanding($order)
    {

    }

    private function createPendingDeal($landing)
    {

    }

    private function showLeaderDeal($leaderDeal)
    {

    }

    public function pushCampaign($order)
    {
        $this->validateOrder($order) or die ("customer is not valid");

        $landing = $this->getLeaderLanding($order) or die("Cannot get landing page for give store");

        $leaderDeal = $this->createPendingDeal($landing);

        $this->showLeaderDeal($leaderDeal);
    }

}
