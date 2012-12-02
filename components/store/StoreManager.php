<?php

class StoreManager implements IStoreManager
{

    private $storeDao;
    private $branchesDao;

    function __construct($storeDao, $branchesDao)
    {
        $this->storeDao = $storeDao;
        $this->branchesDao = $branchesDao;
    }

    public function registerStore($store)
    {
        $store->url = CatBeeExpressions::validateString($store->url);
        $store->logoUrl = CatBeeExpressions::validateString($store->logoUrl);
        if (!$this->storeDao->isStoreExists($store))
        {
            $this->storeDao->insertStore($store);
        }
        else
        {
            $this->storeDao->updateStore($store);
        }
    }

    public function registerBranches($store, $branches)
    {
        $this->registerStore($store);

        RestLogger::log("StoreManager::registerBranches store is ", $store);

        foreach ($branches as $branch)
        {
            $branch->redirectUrl = CatBeeExpressions::validateString($branch->redirectUrl);
            $branch->logoUrl = CatBeeExpressions::validateString($branch->logoUrl);
            $this->branchesDao->AddStoreBranch($store, $branch);
        }

        RestLogger::log("StoreManager::registerBranches branches are ", $branches);
    }

    public function unregisterStore($store)
    {
        // TODO: Implement unregisterStore() method.
    }

    public function unregisterBranches($store, $branches)
    {
        // TODO: Implement unregisterBranches() method.
    }

    public function validateBranch($store, $branch)
    {
        if (!$this->storeDao->isStoreExists($store))
        {
            RestLogger::log("store $store->authCode does not registered in the CatBee");
            throw new Exception("store $store->authCode does not registered in the CatBee");
        }

        if (!$this->branchesDao->isStoreBranchExists($store, $branch))
        {
            RestLogger::log("store $store->authCode branch $branch->shopId does not registered in the CatBee");
            throw new Exception("store $store->authCode branch $branch->shopId does not registered in the CatBee");
        }
    }
    public function getStoreBranches($StoreBranchFilter)
    {
        RestLogger::log('StoreManager::getStoreBranches filter: ', $StoreBranchFilter);
        return $this->branchesDao->getStoreBranches($StoreBranchFilter);
    }

    public function queryStoreAdapter($store, $action)
    {
        if (!$this->storeDao->loadStore($store))
        {
            RestLogger::log('queryStoreAdapter: Cannot load store');
            die("Cannot load store");
        }

        $context = array('act' => $action);
        $response = RestUtils::SendFreePostRequest($store->url, $context);

        RestLogger::log('StoreManager:queryStoreAdapter after', $response);

        return $response;
    }
}
