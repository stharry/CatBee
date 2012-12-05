<?php

class PdoDealShareDao implements IDealShareDao
{

    public function addDealShare($share)
    {
        $names = array("dealId", "shareType", 'value',
            'shareDate', 'status', 'landRewardId');

        $sendTo = $this->unionAllSendTo($share->sendTo);

        $values = array(
            $share->deal->id,
            $share->context->id,
            $sendTo,
            date("Y-m-d h:i:s"),
            $share->status,
            $share->reward->id);

        $share->id = DbManager::insertAndReturnId("activeShare", $names, $values);
    }

    public function updateDealShare($share)
    {
        $value = $this->unionAllSendTo($share->sendTo);

        $update = "UPDATE activeShare
          SET status={$share->status}, value='{$value}'
                    WHERE id={$share->id}";
        $params = array();

        DbManager::updateValues($update, $params);
    }

    public function fillDealShareById($share)
    {
        try
        {
            $select = "SELECT dealId, shareType, status, landRewardId, value
                        FROM activeShare WHERE id = {$share->id}";

            $rows = DbManager::selectValues($select);

            if ($rows == null)
            {
                RestLogger::log("PdoDealShareDao::fillDealShareById share not exists ", $share->id);
                return;
            }

            $share->deal = new LeaderDeal();
            $share->deal->id = $rows[ 0 ][ 'dealId' ];

            $share->context = new ShareContext();
            $share->context->id = $rows[ 0 ][ 'shareType' ];

            $share->status = $rows[ 0 ][ 'status' ];
            $share->reward = new LandingReward();
            $share->reward->id = $rows[ 0 ][ 'landRewardId' ];

            $share->sentTo = $this->value2Customers($rows[ 0 ][ 'value' ]);
        } catch (Exception $e)
        {
            RestLogger::log('Exception', $e->getMessage());
        }
    }
    public function GetDealsShares($deals)
    {


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
            $result .= $customer->email.',';
        }
        return $result;
    }
}
