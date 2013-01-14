<?php

class PdoStoreBranchDao implements IStoreBranchDao
{
    private function fillBranch($branch, $row)
    {
        $branch->id = $row["id"];
        $branch->shopId = $row["shopId"];
        $branch->shopName = $row["shopName"];
        $branch->logoUrl = $row["logoUrl"];
        $branch->url = $row["url"];
        $branch->email = $row["email"];

        $branch->adaptor = new Adaptor();
        $branch->adaptor->id = $row["storeId"];

    }

    public  function isStoreBranchExists($branch)
    {
        $rows = DbManager::selectValues(
            "SELECT id, shopId, shopName, url,
                    logoUrl,email, storeId FROM StoreBranch
            WHERE shopId = {$branch->shopId}",
            array());

        if (!isset($rows)) {
            return false;
        }

        $this->fillBranch($branch, $rows[0]);

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
        $row = DbManager::selectValues("SELECT ShopID,ShopName,url,logoUrl,email FROM StoreBranch
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

    public function loadBranchById($branch)
    {
        $rows = DbManager::selectValues(
            "SELECT id, shopId, shopName, url,
                    logoUrl,email, storeId FROM StoreBranch
            WHERE id = {$branch->id}",
            array());

        if (!isset($rows)) {
            return false;
        }

        $this->fillBranch($branch, $rows[0]);

        return true;
    }


}
