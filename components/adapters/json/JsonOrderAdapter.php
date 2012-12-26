<?php

class JsonOrderAdapter implements IModelAdapter
{

    private $customerAdapter;
    private $itemsAdapter;
    private $branchAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();
        $this->itemsAdapter = new JsonItemsAdapter();
        $this->branchAdapter = new JsonStoreBranchAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'amount' => $obj->amount,
            'id' => $obj->id,
            'customer' => $this->customerAdapter->toArray($obj->customer),
            'items' => $this->itemsAdapter->toArray($obj->items),
            'branch' => $this->branchAdapter->toArray($obj->branch),
            'successfulReferral' => $obj->successfulReferral,
            'date' => $obj->date);
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
        $order->branch = $this->branchAdapter->fromArray($obj["branch"]);
        $order->successfulReferral = $obj["successfulReferral"];
        $order->date = $obj["date"];
        return $order;
    }
}
