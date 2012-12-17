<?php

class PdoStoreBranchDao implements IStoreBranchDao
{

    public  function isStoreBranchExists($branch)
    {
        $rows = DbManager::selectValues("SELECT StoreBranch.id,shopName,StoreBranch.url,StoreBranch.logoUrl,email FROM StoreBranch
          inner join adaptor on StoreBranch.storeid=adaptor.id
            WHERE authcode = '{$branch->adaptor->authCode}' AND shopId = {$branch->shopId}",
            array());

        if (!isset($rows)) {
            return false;
        }
        $branch->id = $rows[0]["id"];
        $branch->shopName = $rows[0]["shopName"];
        $branch->logoUrl = $rows[0]["logoUrl"];
        $branch->url = $rows[0]["url"];
        $branch->email = $rows[0]["email"];

        return true;
    }

    public function addStoreBranch($branch)
    {
        if (!$this->isStoreBranchExists($branch))
        {
            $names = array("storeId", "shopId", "shopName", 'url', 'logoUrl', 'email');
            $values = array(
                $branch->adaptor->id,
                $branch->shopId,
                $branch->shopName,
                $branch->url,
                $branch->logoUrl,
                $branch->email);

            $branch->id = DbManager::insertAndReturnId("StoreBranch", $names, $values);

        }
    }

    public function getStoreBranches($storeBranchFilter)
    {
        $row = DbManager::selectValues("SELECT ShopID,ShopName,url,logoUrl,email FROM storebranch
            WHERE ID = {$storeBranchFilter->ShopID}",
            array());
        $storeBranch = new StoreBranch();
        $storeBranch->shopId = $row[0]["ShopID"];
        $storeBranch->redirectUrl = $row[0]["url"];
        $storeBranch->logoUrl = $row[0]["logoUrl"];
        $storeBranch->email = $row[0]["email"];
        $storeBranch->shopName = $row[0]["ShopName"];
        return $storeBranch;
    }
}
