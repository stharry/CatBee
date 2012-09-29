<?php

interface ICampaignManager
{
    public function chooseCampaign($order);

    public function chooseLeaderLanding($campaign, $order);

    public function getCampaigns($store);

    public function saveCampaign($campaign);
}
