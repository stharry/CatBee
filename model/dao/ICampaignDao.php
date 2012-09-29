<?php

interface ICampaignDao
{
    public function isCampaignExists($campaign);

    public function getCampaigns($store);

    public function insertCampaign($campaign);

    public function updateCampaign($campaign);
}
