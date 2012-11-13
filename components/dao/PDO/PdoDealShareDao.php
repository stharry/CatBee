<?php

class PdoDealShareDao implements IDealShareDao
{

    public function addDealShare($share)
    {
        $names = array("dealId", "shareType", 'value',
            'shareDate', 'status', 'landRewardId');

        $values = array(
            $share->deal->id,
            $share->context->id,
            $share->sendTo,
            date("Y-m-d h:i:s"),
            $share->status,
            $share->reward->id);

        $share->id = DbManager::insertAndReturnId("activeShare", $names, $values);
    }

    public function updateDealShare($share)
    {
        $update = "UPDATE activeShare SET status:=status, value:=value
                    WHERE id:=id";
        $params = array(
            ':=status' => $share->status,
            ':=value' => $share->sendTo,
            ':=id' => $share->id);

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

            $share->sentTo = $rows[ 0 ][ 'value' ];
        } catch (Exception $e)
        {
            RestLogger::log('Exception', $e->getMessage());
        }
    }
}
