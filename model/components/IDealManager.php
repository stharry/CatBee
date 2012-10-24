<?php

interface IDealManager
{
    public function pushDeal($order);

    public function getDealById($dealId);
}
