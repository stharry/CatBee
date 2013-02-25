<?php

interface IStoreManager
{
    public function registerAdaptor($store);

    public function registerBranches($branches);

    public function validateBranch($branch);

    public function queryStoreAdapter($store, $action);

    public function setBranchConfig($branchConfig);

    public function getBranchConfig($branchConfigFilter);
}
