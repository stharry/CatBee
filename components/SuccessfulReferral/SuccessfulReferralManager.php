<?php

class SuccessfulReferralManager
{

    private $successfulReferralDao;

    function __construct($successfulReferralDao)
    {
        $this->successfulReferralDao = $successfulReferralDao;

        RestLogger::log("SuccessfulReferral manager created...");
    }

    public function saveSuccessfulReferral($order)
    {
        if ($order->successfulReferral == null) {
            RestLogger::log('saveSuccessfulReferral no referral to save');
            return;
        }

        $this->successfulReferralDao->SaveReferral($order);
    }

    public function getSuccessfulReferrals($dealFilter)
    {

    }
}