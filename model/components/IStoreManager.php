<?php

interface IStoreManager
{
    public function registerStore($store);

    public function registerBranches($store, $branches);

    public function validateBranch($store, $branch);

    public function unregisterStore($store);

    public function unregisterBranches($store, $branches);

    public function queryStoreAdapter($store, $action);
}
