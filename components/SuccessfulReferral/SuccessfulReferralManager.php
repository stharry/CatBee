<?php

class SuccessfulReferralManager
{

    private $successfulReferralDao;

    function __construct($successfulReferralDao)
    {
        $this->successfulReferralDao = $successfulReferralDao;

        RestLogger::log("SuccessfulReferral manager created...");
    }

    public function saveSucessfulReferral($order)
    {
        if($order->successfulReferral == null) return;
        $successfulReferral = new SuccessfulReferral();
        $successfulReferral->order = $order;
        $share = new Share();
        $share->id = $order->successfulReferral;
        $successfulReferral->share = $share;
        $this->successfulReferralDao->SaveReferral($successfulReferral);
    }

}