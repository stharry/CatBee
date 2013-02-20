<?php

class PdoDealDao implements IDealDao
{
    function __construct()
    {
        RestLogger::log("PdoDealDao created...");
    }

    private function FillActiveShareLeads($row,$dealId,&$indexOfReferralsRows,$referralRows)
    {
        $lead                  = new ShareLead();
        $lead->id              = $row['activeShareID'];
        $lead->shareType       = $row['shareType'];
        $lead->uid             = $row['uid'];
        $lead->status          = $row['status'];
        $lead->landingRewardId = $row['landRewardId'];
        $lead->to              = $row['value'];
        if ($row['ImpTime'])
        {
            array_push($lead->impressions,$row['ImpTime']);
        }
        $this->FillReferralForAnActiveShare($lead,$dealId,$indexOfReferralsRows,$referralRows);
        return $lead;
    }

    private function FillReferralForAnActiveShare($lead,$dealId,&$indexOfReferralsRows,$referralRows)
    {
        RestLogger::log("FillReferralForAnActiveShare index is".$indexOfReferralsRows);
         while($indexOfReferralsRows<count($referralRows))
        {
            if($referralRows[$indexOfReferralsRows]["id"]> $dealId || $referralRows[$indexOfReferralsRows]["activeShareID"]>$lead->id)
            {
                RestLogger::log("break".$indexOfReferralsRows);
                break;
            }
            if($lead->id==$referralRows[$indexOfReferralsRows]["activeShareID"] && $dealId == $referralRows[$indexOfReferralsRows]["id"])
            {
                array_push($lead->referralOrders,$referralRows[$indexOfReferralsRows]["OrderID"]);
                $indexOfReferralsRows = $indexOfReferralsRows+1;
            }
            else
            {
                RestLogger::log("Now What?");
                break;
            }
        }

    }

    private function createAndFillDealHeader($row)
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

        RestLogger::log("PdoDealDao:: deal restored from db ", $leaderDeal);
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

            $leaderDeal = $this->createAndFillDealHeader($rows[0]);

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
            $deal->InitDate,
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
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, landing, status,
             customerId, initDate, updateDate
            FROM deal WHERE orderId = '{$order->id}' AND branchId = {$order->branch->id}";

            $rows = DbManager::selectValues($selectClause,null);

            if ($rows == null)
            {
                RestLogger::log("PdoDealDao::getDealByOrder deal not exists");
                return null;
            }

            $leaderDeal = $this->createAndFillDealHeader($rows[0]);
            $leaderDeal->order = $order;

            return $leaderDeal;

        } catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }
    }
    private function AddReferralsToShares($dealFilter)
    {
        RestLogger::log("PdoDealDao::AddReferralsToShares begin");
        $selectParams = array();
        $flagForWhere=false;

        try
        {
            $selectClause = " SELECT d.id,s.id as activeShareID,sr.OrderID";
            $selectClause = $selectClause." FROM deal d";
            if($dealFilter->customer->email != "")
            {
                $selectClause = $selectClause." INNER JOIN customers c on c.Id=d.customerId";
            }
            $selectClause = $selectClause." INNER JOIN  ActiveShare s on s.dealId=d.id";
            $selectClause = $selectClause." INNER JOIN successfulReferral sr on s.id = sr.ActiveShareID";
            if($dealFilter->customer->email != "")
            {

                $selectClause = $selectClause." WHERE c.email = ?";
                $selectParam = new DbParameter($dealFilter->customer->email,PDO::PARAM_STR);
                array_push($selectParams,$selectParam);
                $flagForWhere=true;
            }
            if($dealFilter->initDateBiggerThen!= null )
            {
                $selectClause = $this->AddWhereStatment($flagForWhere, $selectClause);
                $selectClause= $selectClause. "  d.initDate >= ?";
                $selectParam2 = new DbParameter( $dealFilter->initDateBiggerThen, PDO::PARAM_STR);
                array_push($selectParams,$selectParam2);
            }

            $selectClause = $this->AddWhereStatment($flagForWhere, $selectClause);
            $selectClause = $selectClause . " s.shareType in (";
            foreach($dealFilter->ActiveShareType as $val)
            {
                $selectClause = $selectClause . $val->type.",";
            }
            $selectClause =    substr_replace($selectClause ,"",-1);
            $selectClause = $selectClause . ") and s.status=2 ";

            $selectClause = $selectClause ." Order by d.id,activeShareID";
            $rows = DbManager::selectValues($selectClause,$selectParams);
            return $rows;
        }
        catch (Exception $e)
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
        $selectClause = " SELECT d.id, d.landing, d.status, d.customerId, d.initDate,d.updateDate";
            if (count($dealFilter->ActiveShareType) != 0)
            {
                $selectClause =$selectClause.",s.id as activeShareID,s.shareType,s.landRewardId,s.value,s.uid";
                if($dealFilter->ImpressionFlag == true)
                {
                    $selectClause =$selectClause.", I.TimeStamp as ImpTime";
                }
            }

            $selectClause = $selectClause." FROM deal d";
            if($dealFilter->customer->email != "")
            {
                $selectClause = $selectClause." INNER JOIN customers c on c.Id=d.customerId";
            }
            if (count($dealFilter->ActiveShareType) != 0)
            {
                $selectClause = $selectClause." LEFT JOIN ActiveShare s on s.dealId=d.id";

                if($dealFilter->ImpressionFlag == true)
                {
                    $selectClause = $selectClause." Left JOIN impression I on s.id = I.ActiveShareID";
                }
            }
            if($dealFilter->customer->email != "")
            {

                $selectClause = $selectClause." WHERE c.email = ?";
                $selectParam = new DbParameter($dealFilter->customer->email,PDO::PARAM_STR);
                array_push($selectParams,$selectParam);
                $flagForWhere=true;
             }
            if($dealFilter->initDateBiggerThen!= null )
            {
                $selectClause = $this->AddWhereStatment($flagForWhere, $selectClause);
                $selectClause = $selectClause. "  d.initDate >= ?";
                $selectParam2 = new DbParameter( $dealFilter->initDateBiggerThen, PDO::PARAM_STR);
                array_push($selectParams,$selectParam2);
            }
            if($dealFilter->Campaign !=null)
            {
                $selectClause = $this->AddWhereStatment($flagForWhere, $selectClause);
                $selectClause = $selectClause. "  d.campaignID = ?";
                $selectParam4 = new DbParameter( $dealFilter->Campaign, PDO::PARAM_STR);
                array_push($selectParams,$selectParam4);
            }
            if (count($dealFilter->ActiveShareType) != 0)
            {
                $selectClause = $this->AddWhereStatment($flagForWhere, $selectClause);
                $selectClause = $selectClause . " s.shareType in (";
                foreach($dealFilter->ActiveShareType as $val)
                {
                    $selectClause = $selectClause . $val->type.",";
                }
                $selectClause =    substr_replace($selectClause ,"",-1);
                $selectClause = $selectClause . ") and s.status=2 ";
            }


            $selectClause = $selectClause ." Order by d.id";
            if(count($dealFilter->ActiveShareType) != 0) $selectClause = $selectClause .",activeShareID";

            $rows = DbManager::selectValues($selectClause,$selectParams);
            //adding the Referrals list
            if($dealFilter->ReferralsFlag == true && count($dealFilter->ActiveShareType) != 0)
            {
                $referRows = $this->AddReferralsToShares($dealFilter);
            }

            $leaderDeals = array();
            $indexOfReferralsRows=0;
            $currentDeal =  new LeaderDeal();
            $currentShare = new ShareLead();
            foreach ($rows as $row)
            {

                if($row[ "id" ]==$currentDeal->id)//Same deal
                {
                    if($row[ "activeShareID"] == $currentShare->id)
                    {
                        if($row['ImpTime'])
                        {
                            array_push($currentShare->impressions,$row['ImpTime']) ;

                        }
                    }
                    else//different Share ID
                    {

                        $lead = $this->FillActiveShareLeads($row,$currentDeal->id,$indexOfReferralsRows,$referRows);
                        array_push($currentDeal->leads, $lead);
                        $currentShare = $lead;
                    }
                }
                else//this means it is a New Deal
                {
                    $leaderDeal = $this->createAndFillDealHeader($row);
                    $lead = $this->FillActiveShareLeads($row,$leaderDeal->id,$indexOfReferralsRows,$referRows);
                    array_push($leaderDeal->leads, $lead);
                    $currentShare = $lead;
                    $currentDeal = $leaderDeal;
                    array_push($leaderDeals, $leaderDeal);

                }

            }
            return $leaderDeals;
        }
        catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }

    }

    private function AddWhereStatment(&$flagForWhere, $selectClause)
    {
        if ($flagForWhere == true) {
            $selectClause = $selectClause . " and ";
            return $selectClause;
        } else {
            $selectClause = $selectClause . " where ";
            $flagForWhere = true;
            return $selectClause;
        }
    }


    public function getParentDealByOrderId($id)
    {
        RestLogger::log("PdoDealDao::getDealByOrder begin");

        try
        {
            $selectClause = " SELECT id, landing, status, orderId,
            campaignId, customerId, initDate, updateDate
            FROM deal WHERE orderId = '{$id}' AND parentId IS NULL";

            $rows = DbManager::selectValues($selectClause, array());

            if ($rows == null)
            {
                RestLogger::log("PdoDealDao::getDealByOrder deal not exists");
                return null;
            }

            $leaderDeal = $this->createAndFillDealHeader($rows[0]);

            return $leaderDeal;

        } catch (Exception $e)
        {
            RestLogger::log("Exception: " . $e->getMessage());
            throw new Exception("", 0, $e);
        }
    }

}
