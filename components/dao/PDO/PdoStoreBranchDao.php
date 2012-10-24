<?php

includeModel('dao/IStoreBranchDao');

class PdoStoreBranchDao implements IStoreBranchDao
{

    public  function isStoreBranchExists($store, $branch)
    {
        $rows = DbManager::selectValues("SELECT id FROM StoreBranch
            WHERE storeId = {$store->id} AND shopId = {$branch->shopId}",
            array());

        if (!isset($rows)) {
            return false;
        }
        $branch->id = $rows[0]["id"];

        return true;
    }

    public function addStoreBranch($store, $branch)
    {
        if (!$this->isStoreBranchExists($store, $branch))
        {
            $names = array("storeId", "shopId", "shopName");
            $values = array($store->id,$branch->shopId, $branch->shopName);

            $branch->id = DbManager::insertAndReturnId("StoreBranch", $names, $values);

        }
    }

    public function getStoreBranches($store)
    {
        // TODO: Implement GetStoreBranches() method.
    }
}
