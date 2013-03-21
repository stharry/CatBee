<?php

class JsonStoreBranchAdapter implements IModelAdapter
{
    private $jsonAdaptorAdapter;
    private $jsonStoreRuleAdaptor;


    private function singleBranchFromArray($obj)
    {
        $storeBranch = new StoreBranch();

        $storeBranch->shopId = $obj['shopId'];
        $storeBranch->shopName = $obj['shopName'];
        $storeBranch->redirectUrl = $obj['url'];
        $storeBranch->logoUrl = $obj['logoUrl'];
        $storeBranch->email = $obj['email'];
        $storeBranch->adaptor = $this->jsonAdaptorAdapter->fromArray($obj["store"]);
        $storeBranch->storeRules = $this->jsonStoreRuleAdaptor->fromArray($obj["rules"]);
        return $storeBranch;
    }
    function __construct()
    {
        $this->jsonAdaptorAdapter   = new JsonAdaptorAdapter();
        $this->jsonStoreRuleAdaptor = new JsonStoreRuleAdaptor();
    }
    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $stores= array();

            foreach ($obj as $store)
            {
                array_push($stores, $this->singleStoreToArray($store));
            }
            return $stores;
        }
        else
        {
            return $this->singleStoreToArray($obj);
        }
    }
    private function singleStoreToArray($store)
    {
        return array("id" => $store->id,
            "shopId" => $store->shopId,
            "shopName" => $store->shopName,
            "url" => $store->redirectUrl,
            "logoUrl" => $store->logoUrl,
            "email" => $store->email,
            "store" => $this->jsonAdaptorAdapter->toArray($store->adaptor),
            "rules" => $this->jsonStoreRuleAdaptor->toArray($store->storeRules)
        );
    }

    public function fromArray($obj)
    {
        if ($obj === array_values($obj))
        {
            $branches = array();
            foreach ($obj as $branch)
            {
                array_push($branches, $this->singleBranchFromArray($branch));

            }

            return $branches;
        }
        return $this->singleBranchFromArray($obj);
    }
}
