<?php

class PdoLeadDao implements ILeadDao
{

    public function InsertLead($lead)
    {
        $names  = array("lead","orderID");
        $values = array ($lead->share->id,$lead->order->id);
        DbManager::insert("leads", $names, $values);
    }

}