<?php

class PdoDealDao implements IDealDao
{

    private function createAndFillDeal($row)
    {
        $leaderDeal = new LeaderDeal();

        $leaderDeal->id = $row[ "id" ];
        $leaderDeal->code = $row[ "code" ];
        $leaderDeal->landing = $row[ "landing" ];
        $leaderDeal->status = $row[ "status" ];
        $leaderDeal->landingReward = $row[ "landingReward" ];
        $leaderDeal->customer = $row[ "customerId" ];
        $leaderDeal->initDate = $row[ "initDate" ];
        $leaderDeal->updateDate = $row[ "updateDate" ];
        $leaderDeal->campaign = new Campaign();
        $leaderDeal->campaign->id = $row['campaignId'];

        RestLogger::log("PdoDealDao::getDealByOrder deal restored from db ", $leaderDeal);

        return $leaderDeal;

    }

    public function getDealById($id)
    {
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, code, landing, status,
            campaignId, landingReward, customerId, initDate, updateDate
            FROM deal WHERE id = {$id} ";

            $rows = DbManager::selectValues($selectClause);

            if ($rows == null)
            {
                RestLogger::log("PdoDealDao::getDealByOrder deal not exists");
                return null;
            }

            $leaderDeal = $this->createAndFillDeal($rows[0]);

            return $leaderDeal;

        } catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }

        // TODO: Implement getDealById() method.
    }

    public function insertDeal($deal)
    {
        $names = array("code", "landing", 'campaignId', "branchId",
            "orderId", "status",
            "landingReward", "customerId", "initDate", "updateDate");

        $values = array($deal->uniqueCode,
            $deal->landing->id,
            $deal->campaign->id,
            $deal->order->branch->id,
            $deal->order->id,
            $deal->status,
            $deal->selectedLandingReward,
            $deal->customer->id,
            date("Y-m-d h:i:s"),
            date("Y-m-d h:i:s"));

        $deal->id = DbManager::insertAndReturnId("deal", $names, $values);
    }

    public function updateDealStatus($deal)
    {
        // TODO: Implement updateDealStatus() method.
    }

    public function getDealByOrder($order)
    {
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, code, landing, status,
            landingReward, customerId, initDate, updateDate
            FROM deal WHERE orderId = {$order->id} AND branchId = {$order->branch->id}";

            $rows = DbManager::selectValues($selectClause);

            if ($rows == null)
            {
                RestLogger::log("PdoDealDao::getDealByOrder deal not exists");
                return null;
            }

            $leaderDeal = $this->createAndFillDeal($rows[0]);
            $leaderDeal->order = $order;

            return $leaderDeal;

        } catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }
    }
}
