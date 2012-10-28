<?php

class PdoStoreDao implements IStoreDao
{

    public function isStoreExists($store)
    {
        $rows = DbManager::selectValues("SELECT id FROM store  WHERE authCode=?",
            array($store->authCode => PDO::PARAM_STR));

        if (!isset($rows)) {
            return false;
        }
        $store->id = $rows[0]["id"];

        return true;
    }

    public function insertStore($store)
    {
        $names = array("authCode", "description", "url");
        $values = array($store->authCode,$store->description, $store->url);

        $store->id = DbManager::insertAndReturnId("store", $names, $values);
    }

    public function updateStore($store)
    {
        // TODO: Implement UpdateStore() method.
    }
}
