<?php

class PdoSuccessfulReferralDao implements ISuccessfulReferralDao
{

    public function SaveReferral($order)
    {
        $rows = DbManager::selectValues("SELECT id from ActiveShare WHERE uid =? ",
                                        array(new DbParameter($order->successfulReferral, PDO::PARAM_INT)));

        $names = array("ActiveShareID", "orderID");

        $values = array($rows[0]['id'], $order->id);

        DbManager::insertOnly("successfulReferral", $names, $values);
    }

    public function GetReferrals($leadFilter)
    {
    }

}