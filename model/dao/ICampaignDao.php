<?php

interface ICampaignDao
{
    public function isCampaignExists($campaign);

    public function getCampaigns($campaignFilter);

    public function insertCampaign($campaign);

    public function updateCampaign($campaign);
}
