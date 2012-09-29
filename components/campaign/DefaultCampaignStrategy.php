<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/components/ICampaignStrategy.php");

class DefaultCampaignStrategy implements ICampaignStrategy
{

    public function chooseCampaign($campaigns, $order)
    {
        return$campaigns[0];
    }
}
