<?php

class PdoLeadDao implements ILeadDao
{

    public function InsertLead($lead)
    {
        $names  = array("lead","orderID");
        $values = array ($lead->share->id,$lead->order->id);
        DbManager::insertOnly("leads", $names, $values);
    }
    public function GetLead($leadFilter)
    {


    }

}