<?php

class PdoSuccessfulReferralDao implements ISuccessfulReferralDao
{

    public function SaveReferral($SuccessfulReferral)
    {
        $names  = array("ActiveShareID","orderID");
        $values = array ($SuccessfulReferral->share->id,$SuccessfulReferral->order->id);
        DbManager::insertOnly("successfulreferral", $names, $values);
    }
    public function GetReferrals($leadFilter)
    {


    }

}