<?php

class JsonOrderAdapter implements IModelAdapter
{

    private $customerAdapter;
    private $itemsAdapter;
    private $storeAdapter;
    private $branchAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();
        $this->itemsAdapter = new JsonItemsAdapter();
        $this->storeAdapter = new JsonStoreAdapter();
        $this->branchAdapter = new JsonStoreBranchAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'amount' => $obj->amount,
            'id' => $obj->id,
            'customer' => $this->customerAdapter->toArray($obj->customer),
            'items' => $this->itemsAdapter->toArray($obj->items),
            'store' => $this->storeAdapter->toArray($obj->store),
            'branch' => $this->branchAdapter->toArray($obj->branch),
            'lead' => $obj->lead,

        );
    }

    public function fromArray($obj)
    {

        RestLogger::log("JsonOrderAdapter::fromArray ", $obj);

        $order = new Order();

        $order->amount = $obj["amount"];
        $order->id = $obj["id"];
        $order->activeShareId = $obj["activeShareId"];

        $order->customer = $this->customerAdapter->fromArray($obj["customer"]);
        $order->items = $this->itemsAdapter->fromArray($obj["items"]);
        $order->store = $this->storeAdapter->fromArray($obj["store"]);
        $order->branch = $this->branchAdapter->fromArray($obj["branch"]);
        $order->lead = $obj["lead"];
        return $order;
    }
}
