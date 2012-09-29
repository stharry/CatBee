<?php

interface ICampaignStrategy
{
    public function chooseCampaign($campaigns, $order);

}
