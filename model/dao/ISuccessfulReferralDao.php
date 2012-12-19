<?php

interface ISuccessfulReferralDao
{
    public function SaveReferral($SuccessfulReferral);
    public function GetReferrals($LeadFilter);

}