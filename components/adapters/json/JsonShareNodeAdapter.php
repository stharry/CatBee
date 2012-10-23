<?php

include_once("JsonCustomerAdapter.php");
include_once("JsonShareContextAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareNode.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");

class JsonShareNodeAdapter implements IModelAdapter
{

    private $customerAdapter;
    private $contextAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();
        $this->contextAdapter = new JsonShareContextAdapter();
    }
    public function toArray($obj)
    {
        return array(
            "leader" => $this->customerAdapter->toArray($obj->leader),
            "context" => $this->contextAdapter->toArray($obj->context),
            "friends" => $this->customerAdapter->toArray($obj->friends)

        );
    }

    public function fromArray($obj)
    {
        $shareNode = new ShareNode();

        $shareNode->leader = $this->customerAdapter->fromArray($obj["leader"]);
        $shareNode->context = $this->contextAdapter->fromArray($obj["context"]);

        return$shareNode;
    }
}
