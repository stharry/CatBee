<?php

interface IDealDao
{
    public function getDealById($id);

    public function getParentDealByOrderId($id);

    public function getDealByOrder($order);

    public function getDealsByFilter($dealFilter);

    public function insertDeal($deal);

    public function updateDealStatus($deal);
}
