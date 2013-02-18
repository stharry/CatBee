<?php

interface ICampaignManager
{
    public function chooseCampaign($order);

    public function chooseLeaderLanding($campaign, $order);

    public function getCampaigns($campaignFilter);

    public function saveCampaign($campaign);

    public function getCampaignFriendLanding($campaign);

    public function getDiscounts($campaignFilter);
}
