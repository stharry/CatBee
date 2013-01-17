<?php

class PdoDealShareDao implements IDealShareDao
{

    private function FillActiveShareLeads($row)
    {
        $lead                  = new ShareLead();
        $lead->id              = $row['id'];
        $lead->shareType       = $row['shareType'];
        $lead->uid             = $row['uid'];
        $lead->status          = $row['status'];
        $lead->landingRewardId = $row['landRewardId'];
        $lead->to              = $row['value'];
        $lead->order           = $row['OrderID'];

        return $lead;
    }

    private function value2Customers($value)
    {
        $customers = array();

        foreach (explode(',', $value) as $email)
        {
            $customer = new Customer($email);
            array_push($customers, $customer);
        }

        return $customers;
    }

    private function unionAllSendTo($sendTo)
    {
        $result = '';

        foreach ($sendTo as $customer)
        {
            $result .= $customer->email . ',';
        }

        return $result;
    }

    public function addDealShare($share)
    {
        $names = array("dealId", "shareType", 'value', 'uid',
            'shareDate', 'status', 'landRewardId');

        $sendTo = $this->unionAllSendTo($share->currentTarget->to);

        $values = array(
            $share->deal->id,
            $share->context->id,
            $sendTo,
            $share->context->uid,
            date("Y-m-d h:i:s"),
            $share->status,
            $share->reward->id);

        $share->id = DbManager::insertAndReturnId("ActiveShare", $names, $values);
    }

    public function updateDealShare($share)
    {
        $value = $this->unionAllSendTo($share->currentTarget->to);

        $update = "UPDATE ActiveShare
          SET status={$share->status}, value='{$value}'
                    WHERE uid={$share->context->uid}";
        $params = array();

        DbManager::updateValues($update, $params);
    }

    public function fillDealShareById($share)
    {
        //TODO - Merge this Function with the function GetDealsShares
        try
        {
            $select = "SELECT id,dealId, shareType, status, landRewardId, value
                        FROM ActiveShare WHERE uid=?";

            $rows = DbManager::selectValues($select,
                                            array(new DbParameter($share->context->uid, PDO::PARAM_STR)));

            if ($rows == null)
            {
                RestLogger::log("PdoDealShareDao::fillDealShareById share not exists ", $share->id);

                return;
            }
            $share->id  =  $rows[0]['id'];
            $share->deal     = new LeaderDeal();
            $share->deal->id = $rows[0]['dealId'];

            $share->context->id = $rows[0]['shareType'];

            $share->status     = $rows[0]['status'];
            $share->reward     = new LandingReward();
            $share->reward->id = $rows[0]['landRewardId'];

            $share->addTarget($this->value2Customers($rows[0]['value']));
        }
        catch (Exception $e)
        {
            RestLogger::log('Exception', $e->getMessage());
        }
    }

    public function GetDealsShares($deals, $getLeads)
    {
        //This Loop over Deal is assuming each Customer wont have a lot of active Deal.
        //TODO - change the above assumption

        foreach ($deals as $deal)
        {
            if ($getLeads)
            {
                $select = "SELECT share.id,share.dealId, share.shareType, share.landRewardId, share.value,
                           share.uid, L.OrderID FROM ActiveShare share";
                $select = $select . " LEFT JOIN successfulReferral L on Share.id = L.ActiveShareID";
                $select = $select . " WHERE share.dealid = ? ";
            }
            else
            {
                $select = "SELECT share.dealId, share.shareType, share.status, share.landRewardId,
                                  share.value, share.uid
                            FROM ActiveShare share";
                $select = $select . " WHERE share.dealid = ? ";
            }
            $select     = $select . " and share.status=2";
            $rows       = DbManager::selectValues($select,
                                                  array(new DbParameter($deal->id, PDO::PARAM_INT)));
            $leadsArray = array();
            $sharesByIds = array();

            foreach ($rows as $row)
            {
                if (!array_key_exists($row['id'], $sharesByIds))
                {
                    $lead = $this->FillActiveShareLeads($row);
                    array_push($leadsArray, $lead);
                }
                else
                {
                    $lead = $sharesByIds[$row['id']];
                }
                $orderId = $row['OrderID'];
                if ($orderId)
                {
                    if (!$lead->referralOrders)
                    {
                        $lead->referralOrders = array();
                    }
                    array_push($lead->referralOrders, $orderId);
                }

            }

            $deal->leads = $leadsArray;
        }

    }


}
