<?php

class DefaultCampaignStrategy implements ICampaignStrategy
{

    public function chooseCampaign($campaigns, $order)
    {
        return$campaigns[0];
    }
}
