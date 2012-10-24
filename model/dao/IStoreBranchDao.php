<?php

interface IStoreBranchDao
{
    public function isStoreBranchExists($store, $branch);

    public function addStoreBranch($store, $branch);

    public function getStoreBranches($store);
}
