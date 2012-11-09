<?php

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
            $names = array("storeId", "shopId", "shopName", 'url');
            $values = array($store->id,$branch->shopId,
                            $branch->shopName, $branch->url);

            $branch->id = DbManager::insertAndReturnId("StoreBranch", $names, $values);

        }
    }

    public function getStoreBranches($storeBranchFilter)
    {
        $row = DbManager::selectValues("SELECT ShopID,ShopName FROM storebranch
            WHERE ShopID = {$storeBranchFilter->ShopID}",
            array());
        $storeBranch = new StoreBranch();
        $storeBranch->shopId = $row[0]["ShopID"];
        $storeBranch->shopName = $row[0]["ShopName"];
        return $storeBranch;
    }
}
