<?php

class JsonOrderAdapter implements IModelAdapter
{

    private $customerAdapter;
    private $purchasesAdapter;
    private $storeAdapter;
    private $branchAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();
        $this->purchasesAdapter = new JsonPurchasesAdapter();
        $this->storeAdapter = new JsonStoreAdapter();
        $this->branchAdapter = new JsonStoreBranchAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'amount' => $obj->amount,
            'id' => $obj->id,
            'customer' => $this->customerAdapter->toArray($obj->customer),
            'purchases' => $this->purchasesAdapter->toArray($obj->purchases),
            'store' => $this->storeAdapter->toArray($obj->store),
            'branch' => $this->branchAdapter->toArray($obj->branch),
            'lead' => $obj->lead,

        );
    }

    public function fromArray($obj)
    {

        $order = new Order();

        $order->amount = $obj["amount"];
        $order->id = $obj["id"];

        $order->customer = $this->customerAdapter->fromArray($obj["customer"]);
        $order->purchases = $this->purchasesAdapter->fromArray($obj["purchases"]);
        $order->store = $this->storeAdapter->fromArray($obj["store"]);
        $order->branch = $this->branchAdapter->fromArray($obj["branch"]);
        $order->lead = $obj["lead"];
        return $order;
    }
}
