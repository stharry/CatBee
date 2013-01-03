<?php

class JsonLeaderDealAdapter implements IModelAdapter
{
    private $orderAdapter;
    private $landingPageAdapter;
    private $customerAdapter;
    private $campaignAdapter;
    private $contextAdapter;

//    private $shareContextsAdapter;

    function __construct()
    {
        $this->orderAdapter       = new JsonOrderAdapter();
        $this->landingPageAdapter = new JsonLeaderLandingAdapter();
        $this->customerAdapter    = new JsonCustomerAdapter();
        $this->campaignAdapter    = new JsonCampaignAdapter();
        $this->contextAdapter     = new JsonShareContextAdapter();
        //      $this->sharesAdapter = new JsonShareAdapter();

    }

    public function toArray($obj)
    {
        return array(
            'id'         => $obj->id,
            'order'      => $this->orderAdapter->toArray($obj->order),
            'landing'    => $this->landingPageAdapter->toArray($obj->landing),
            'customer'   => $this->customerAdapter->toArray($obj->customer),
            'sharePoint' => $obj->sharePoint,
            'campaign'   => $this->campaignAdapter->toArray($obj->campaign),
            'fbcContext' => $this->contextAdapter->toArray($obj->fbcContext)
            //'shares' => $this->sharesAdapter->toArray($obj->shares)
        );
    }

    public function fromArray($obj)
    {
        $deal     = new LeaderDeal();
        $deal->id = is_array($obj) ? $obj['id'] : $obj;

        $deal->order      = $this->orderAdapter->fromArray($obj['order']);
        $deal->landing    = $this->landingPageAdapter->fromArray($obj['landing']);
        $deal->customer   = $this->customerAdapter->fromArray($obj['customer']);
        $deal->campaign   = $this->campaignAdapter->fromArray($obj['campaign']);
        $deal->fbcContext = $this->contextAdapter->fromArray($obj['fbcContext']);

        return $deal;
    }
}
