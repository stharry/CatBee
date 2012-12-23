<?php

class SuccessfulReferralManager
{

    private $succssefullReferalDao;

    function __construct($succssefullReferalDao)
    {
        $this->succssefullReferalDao = $succssefullReferalDao;

        RestLogger::log("SuccessfulReferral manager created...");
    }
    public function saveSucessfulReferral($order)
    {
        if($order->successfulReferral == null) return;
        $succssefullReferal = new SuccessfulReferral();
        $succssefullReferal->order = $order;
        $share = new Share();
        $share->id = $order->successfulReferral;
        $succssefullReferal->share = $share;
        $this->succssefullReferalDao->SaveReferral($succssefullReferal);
    }

}