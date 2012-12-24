<?php

class PdoDealDao implements IDealDao
{
    function __construct()
    {
        RestLogger::log("PdoDealDao created...");
    }

    private function createAndFillDeal($row)
    {
        $leaderDeal = new LeaderDeal();

        $leaderDeal->id = $row[ "id" ];
        $leaderDeal->landing = $row[ "landing" ];
        $leaderDeal->status = $row[ "status" ];
        $leaderDeal->customer = $row[ "customerId" ];
        $leaderDeal->initDate = $row[ "initDate" ];
        $leaderDeal->updateDate = $row[ "updateDate" ];
        $leaderDeal->campaign = new Campaign();
        $leaderDeal->campaign->id = $row['campaignId'];
        $leaderDeal->order = new Order();
        $leaderDeal->order->id = $row['orderId'];

        RestLogger::log("PdoDealDao::getDealByOrder deal restored from db ", $leaderDeal);
        return $leaderDeal;

    }

    public function getDealById($id)
    {
        RestLogger::log("PdoDealDao::getDealByID begin");

        try
        {
            $selectClause = " SELECT id, landing, status, orderId,
            campaignId, customerId, initDate, updateDate
            FROM deal WHERE id = {$id} ";

            $rows = DbManager::selectValues($selectClause,null);

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
    }

    public function insertDeal($deal)
    {
        $names = array( "landing", 'campaignId', "branchId",
            "orderId", "status",
             "customerId", "initDate", "updateDate");

        $values = array(
            $deal->landing->id,
            $deal->campaign->id,
            $deal->order->branch->id,
            $deal->order->id,
            $deal->status,
            $deal->customer->id,
            date("Y-m-d h:i:s"),
            date("Y-m-d h:i:s"));

        $deal->id = DbManager::insertAndReturnId("deal", $names, $values);
    }

    public function updateDealStatus($deal)
    {
        $sql = "UPDATE deal SET status=:status WHERE id=:id";

        $params = array(
            ':status' => $deal->status,
            ':id' => $deal->id);

        DbManager::updateValues($sql, $params);
    }

    public function getDealByOrder($order)
    {
        //Todo - Remove this function  - all Get Functions should be in the same Get
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, landing, status,
             customerId, initDate, updateDate
            FROM deal WHERE orderId = {$order->id} AND branchId = {$order->branch->id}";

            $rows = DbManager::selectValues($selectClause,null);

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
    public function getDealsByFilter($dealFilter)
    {
        RestLogger::log("PdoDealDao::getDealsByFilter begin");
        $selectParams = array();
        $flagForWhere=false;
        try
        {
        $selectClause = " SELECT d.id, d.landing, d.status, d.customerId, d.initDate, d.updateDate
            FROM deal d";
            if($dealFilter->customer != null)
            {

                $selectClause = $selectClause." Inner JOIN customers c on c.Id=d.customerId WHERE c.email = ?";
                $selectParam = new DbParameter($dealFilter->customer->email,PDO::PARAM_STR);
                array_push($selectParams,$selectParam);
                $flagForWhere=true;
            }
            if($dealFilter->initDateBiggerThen!= null )
            {
                if($flagForWhere==true)
                {
                    $selectClause = $selectClause. " and d.initDate >= ?";
               }
                $selectParam2 = new DbParameter( $dealFilter->initDateBiggerThen, PDO::PARAM_STR);
                array_push($selectParams,$selectParam2);

            }
            $rows = DbManager::selectValues($selectClause,$selectParams);
            $leaderDeals = array();

            foreach ($rows as $row)
            {

                $leaderDeal = $this->createAndFillDeal($row);
                array_push($leaderDeals, $leaderDeal);
            }
            return $leaderDeals;
        }
        catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }

    }

    public function getParentDealByOrderId($id)
    {
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, landing, status, orderId,
            campaignId, customerId, initDate, updateDate
            FROM deal WHERE orderId = {$id} AND parentId IS NULL";

            $rows = DbManager::selectValues($selectClause, array());

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
    }
}
