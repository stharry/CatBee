<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/CustomerShareContext.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/adapters/IModelAdapter.php");
include_once("JsonShareContextAdapter.php");
include_once("JsonCustomerAdapter.php");

class JsonCustomerShareContextAdapter implements IModelAdapter
{

    private $jsonCustomerAdapter;
    private $jsonShareContextAdapter;

    function __construct()
    {
        $this->jsonShareContextAdapter = new JsonShareContextAdapter();
        $this->jsonCustomerAdapter = new JsonCustomerAdapter();
    }

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $customerShareContext = new CustomerShareContext();

        $customerShareContext->customer =
            $this->jsonCustomerAdapter->fromArray($obj["customer"]);
        $customerShareContext->shareContext =
            $this->jsonShareContextAdapter->fromArray($obj["shareContext"]);

        return $customerShareContext;
    }
}
