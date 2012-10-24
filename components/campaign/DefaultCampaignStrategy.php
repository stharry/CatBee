<?php

includeModel('components/ICampaignStrategy');

class DefaultCampaignStrategy implements ICampaignStrategy
{

    public function chooseCampaign($campaigns, $order)
    {
        return$campaigns[0];
    }
}
