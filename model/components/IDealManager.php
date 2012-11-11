<?php

interface IDealManager
{
    public function pushDeal($order);

    public function getDealById($dealId);

    public function updateDeal($deal);

    public function addDealShare($share);

    public function shareDeal($share);

    public function fillDealShare($share);
}
