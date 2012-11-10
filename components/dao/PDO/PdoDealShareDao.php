<?php

class PdoDealShareDao implements IDealShareDao
{

    public function addDealShare($share)
    {
        $names = array("dealId", "shareType", 'value', 'shareDate');

        $values = array(
            $share->deal->id,
            $share->context->id,
            $share->sendTo,
            date("Y-m-d h:i:s"));

        DbManager::insert("activeShare", $names, $values);
    }
}
