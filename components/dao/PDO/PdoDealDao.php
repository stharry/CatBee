<?php

include_once("../../model/dao/IDealDao.php");
include_once("../../model/LeaderDeal.php");
include_once("../DbManager.php");

class PdoDealDao implements IDealDao
{

    public function getDealById($id)
    {
        // TODO: Implement getDealById() method.
    }

    public function insertDeal($deal)
    {
        $names = array("code", "landing", "order", "status",
            "landingReward", "customer", "initDate", "updateDate");

        $values = array($deal->uniqueCode, $deal->landing->id,
            $deal->order->id, LeaderDeal::$STATUS_PENDING,
            $deal->selectedLandingReward->leaderReward->value,
            $deal->customer->id, time(), time());

        $deal->id = DbManager::insertAndReturnId("deal", $names, $values);
    }

    public function updateDealStatus($deal)
    {
        // TODO: Implement updateDealStatus() method.
    }
}
