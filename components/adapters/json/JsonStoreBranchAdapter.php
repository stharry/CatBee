<?php

class JsonStoreBranchAdapter implements IModelAdapter
{
    private $jsonAdaptorAdapter;



    private function singleBranchFromArray($obj)
    {
        $storeBranch = new StoreBranch();

        $storeBranch->shopId = $obj['shopId'];
        $storeBranch->shopName = $obj['shopName'];
        $storeBranch->redirectUrl = $obj['url'];
        $storeBranch->logoUrl = $obj['logoUrl'];
        $storeBranch->email = $obj['email'];
        $storeBranch->adaptor = $this->jsonAdaptorAdapter->fromArray($obj["store"]);

        return $storeBranch;
    }
    function __construct()
    {
        $this->jsonAdaptorAdapter         = new JsonAdaptorAdapter();
    }
//    public function toArray($obj)
//    {
//        RestLogger::log("Starting Json store adaptor",$obj);
//        return array(
//            'shopId' => $obj->shopId,
//            'shopName' => $obj->shopName,
//            'url' => $obj->url,
//            'email' => $obj->email,
//            'store' => $this->jsonAdaptorAdapter->toArray($obj->adaptor)
//
//        );
//    }

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
            "store" => $this->jsonAdaptorAdapter->toArray($store->adaptor)
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
