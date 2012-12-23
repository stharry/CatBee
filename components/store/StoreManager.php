<?php

class StoreManager implements IStoreManager
{

    private $adaptorDao;
    private $branchesDao;

    function __construct($adaptorDao, $branchesDao)
    {
        $this->adaptorDao = $adaptorDao;
        $this->branchesDao = $branchesDao;

        RestLogger::log("Store manager created...");
    }

    public function registerAdaptor($store)
    {
        $store->url = CatBeeExpressions::validateString($store->url);
        $store->logoUrl = CatBeeExpressions::validateString($store->logoUrl);
        if (!$this->adaptorDao->isAdaptorExists($store))
        {
            $this->adaptorDao->insertAdaptor($store);
        }
    }

    public function registerBranches($branches)
    {
        foreach ($branches as $branch)
        {
            $branch->redirectUrl = CatBeeExpressions::validateString($branch->redirectUrl);
            $branch->logoUrl = CatBeeExpressions::validateString($branch->logoUrl);

            $this->branchesDao->AddStoreBranch($branch);
        }
        RestLogger::log("StoreManager::registerBranches branches are ", $branches);
    }


    public function validateBranch($branch)
    {
        if ($branch->id > 0)
        {
            return;
        }
        if (!$this->branchesDao->isStoreBranchExists($branch))
        {
            RestLogger::log(" branch $branch->shopId does not registered in the CatBee");
            throw new Exception("branch $branch->shopId does not registered in the CatBee");
        }
        if ($branch->adaptor->id)
        {
            $this->adaptorDao->loadAdaptorById($branch->adaptor);
        }
        else
        {
            $this->adaptorDao->loadAdaptor($branch->adaptor);
        }
    }

    public function getStoreBranches($StoreBranchFilter)
    {
        RestLogger::log('StoreManager::getStoreBranches filter: ', $StoreBranchFilter);
        return $this->branchesDao->getStoreBranches($StoreBranchFilter);
    }

    public function queryStoreAdapter($store, $action)
    {
        if (!$store->url)
        {
            $this->adaptorDao->loadAdaptorById($store);

        }
        $context = array('act' => $action);
        $response = RestUtils::SendFreePostRequest($store->url, $context);

        RestLogger::log('StoreManager:queryStoreAdapter after', $response);

        return $response;
    }
}
