<?php

interface IDealDao
{
    public function getDealById($id);

    public function getDealByOrder($order);

    public function insertDeal($deal);

    public function updateDealStatus($deal);
}
