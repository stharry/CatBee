<?php

class LeadManager
{

    private $leadDao;

    function __construct($leadDao)
    {
        $this->leadDao = $leadDao;
    }
    public function saveLead($order)
    {
        //Check the Share ID is not Null
        if($order->lead == null) return;
        $lead = new Lead();
        $lead->order = $order;
        $share = new Share();
        $share->id = $order->lead;
        $lead->share = $share;
        $this->leadDao->InsertLead($lead);
    }

}