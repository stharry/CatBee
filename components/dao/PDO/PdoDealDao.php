<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/dao/IDealDao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/LeaderDeal.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/dao/DbManager.php");

class PdoDealDao implements IDealDao
{

    public function getDealById($id)
    {
        // TODO: Implement getDealById() method.
    }

    public function insertDeal($deal)
    {
        $names = array("code", "landing", "orderId", "status",
            "landingReward", "customerId", "initDate", "updateDate");

        $values = array($deal->uniqueCode, $deal->landing->id,
            $deal->order->id, $deal->status,
            $deal->selectedLandingReward,
            $deal->customer->id, date("Y-m-d h:i:s"),
            date("Y-m-d h:i:s"));

        $deal->id = DbManager::insertAndReturnId("deal", $names, $values);
    }

    public function updateDealStatus($deal)
    {
        // TODO: Implement updateDealStatus() method.
    }

    public function getDealByOrder($order)
    {
        $rows = DbManager::selectValues(" SELECT id, code, landing, status,
            landingReward, customer, initDate, updateDate
            FROM deal WHERE order = ?",
            array($order->id => PDO::PARAM_INT));

        if ($rows == null)
        {
            return null;
        }

        $leaderDeal = new LeaderDeal();

        $leaderDeal->id = $rows[0]["id"];
        $leaderDeal->code = $rows[0]["code"];
        $leaderDeal->landing = $rows[0]["landing"];
        $leaderDeal->status = $rows[0]["status"];
        $leaderDeal->landingReward = $rows[0]["landingReward"];
        $leaderDeal->customer = $rows[0]["customer"];
        $leaderDeal->initDate = $rows[0]["initDate"];
        $leaderDeal->updateDate = $rows[0]["updateDate"];

        return $leaderDeal;
    }
}
