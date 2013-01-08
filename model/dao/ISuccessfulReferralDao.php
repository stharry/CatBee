<?php

interface ISuccessfulReferralDao
{
    public function SaveReferral($order);
    public function GetReferrals($LeadFilter);

}