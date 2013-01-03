<?php

class PdoDealShareDao implements IDealShareDao
{

    private function FillActiveShareLeads($row)
    {
        $share = new Share();
        $share->id =$row['id'];
        $share->context = new ShareContext();
        $share->context->id = $row['shareType'];

        $share->status = $row['status'];
        $share->reward = new LandingReward();
        $share->reward->id = $row['landRewardId'];

        $share->sentTo = $this->value2Customers($row['value']);
        $SuccessfulReferral = $share->addReferral();
        $SuccessfulReferral->share = $row['id'];
        $SuccessfulReferral->order = $row['OrderID'];
        return $share;
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

        $share->id = DbManager::insertAndReturnId("activeShare", $names, $values);
    }

    public function updateDealShare($share)
    {
        $value = $this->unionAllSendTo($share->currentTarget->to);

        $update = "UPDATE activeShare
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
            $select = "SELECT dealId, shareType, status, landRewardId, value
                        FROM activeShare WHERE uid = {$share->context->uid}";

            $rows = DbManager::selectValues($select, array());

            if ($rows == null)
            {
                RestLogger::log("PdoDealShareDao::fillDealShareById share not exists ", $share->id);

                return;
            }

            $share->deal     = new LeaderDeal();
            $share->deal->id = $rows[ 0 ][ 'dealId' ];

            $share->context     = new ShareContext();
            $share->context->id = $rows[ 0 ][ 'shareType' ];

            $share->status     = $rows[ 0 ][ 'status' ];
            $share->reward     = new LandingReward();
            $share->reward->id = $rows[ 0 ][ 'landRewardId' ];

            $share->sentTo = $this->value2Customers($rows[ 0 ][ 'value' ]);
        } catch (Exception $e)
        {
            RestLogger::log('Exception', $e->getMessage());
        }
    }
    public function GetDealsShares($deals,$getLeads)
    {
        //This Loop over Deal is assuming each Customer wont have a lot of active Deal.
        //TODO - change the above assumption
        $selectParams = array();
        $iterator = 0;
        foreach($deals as $deal)
        {
            if($getLeads)
            {
                $select = "SELECT share.id,share.dealId, share.shareType, share.landRewardId, share.value,
                           L.OrderID FROM activeShare share" ;
                 $select = $select." LEFT JOIN successfulReferral L on Share.id = L.ActiveShareID";
                $select = $select." WHERE share.dealid = ? ";
            }
            else
            {
                $select = "SELECT share.dealId, share.shareType, share.status, share.landRewardId, share.value
                            FROM activeShare share" ;
                $select = $select." WHERE share.dealid = ? ";
            }
            $select = $select." and share.status=2";
            $selectParam = new DbParameter($deals[$iterator]->id,PDO::PARAM_INT);
            array_push($selectParams,$selectParam);
            $rows = DbManager::selectValues($select,$selectParams);
            $shareArray = array();
            foreach ($rows as $row)
            {
                $share = $this->FillActiveShareLeads($row);
                array_push($shareArray, $share);
            }

            $deals[$iterator]->shares = $shareArray;
            $iterator++;
        }

    }


}
