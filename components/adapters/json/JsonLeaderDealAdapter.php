<?php

class JsonLeaderDealAdapter implements IModelAdapter
{
    private $orderAdapter;
    private $landingPageAdapter;
    private $customerAdapter;
//    private $shareContextsAdapter;

    function __construct()
    {
        $this->orderAdapter = new JsonOrderAdapter();
        $this->landingPageAdapter = new JsonLeaderLandingAdapter();
        $this->customerAdapter = new JsonCustomerAdapter();
  //      $this->sharesAdapter = new JsonShareAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'id' => $obj->id,
            'order' => $this->orderAdapter->toArray($obj->order),
            'landing' => $this->landingPageAdapter->toArray($obj->landing),
            'customer' => $this->customerAdapter->toArray($obj->customer),
            'sharePoint' => $obj->sharePoint
            //'shares' => $this->sharesAdapter->toArray($obj->shares)
        );
    }

    public function fromArray($obj)
    {
        $deal = new LeaderDeal();
        $deal->id = $obj['id'];

        return $deal;
    }
}
