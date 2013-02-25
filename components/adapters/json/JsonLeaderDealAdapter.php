<?php

class JsonLeaderDealAdapter implements IModelAdapter
{
    private $orderAdapter;
    private $landingPageAdapter;
    private $customerAdapter;
    private $campaignAdapter;
    private $contextAdapter;
    private $leadsAdapter;

    function __construct()
    {
        $this->orderAdapter       = new JsonOrderAdapter();
        $this->landingPageAdapter = new JsonLeaderLandingAdapter();
        $this->customerAdapter    = new JsonCustomerAdapter();
        $this->campaignAdapter    = new JsonCampaignAdapter();
        $this->contextAdapter     = new JsonShareContextAdapter();
        $this->leadsAdapter       = new JsonLeadsAdapter();

    }

    public function toArray($obj)
    {
        $dealProps = array(
            'id'          => $obj->id,
            'order'       => $this->orderAdapter->toArray($obj->order),
            'landing'     => $this->landingPageAdapter->toArray($obj->landing),
            'customer'    => $this->customerAdapter->toArray($obj->customer),
            'campaign'    => $this->campaignAdapter->toArray($obj->campaign),
            'fbcContext'  => $this->contextAdapter->toArray($obj->fbcContext),
            'twitContext' => $this->contextAdapter->toArray($obj->twitContext),
            'pintContext' => $this->contextAdapter->toArray($obj->pintContext)
        );

        if ($obj->leads)
        {
            $leadsProps = array();

            foreach ($obj->leads as $lead)
            {
                array_push($leadsProps, $this->leadsAdapter->toArray($lead));
            }
            $dealProps['leads'] = $leadsProps;
        }

        return $dealProps;
    }

    public function fromArray($obj)
    {
        $deal     = new LeaderDeal();
        $deal->id = is_array($obj) ? $obj['id'] : $obj;

        $deal->order       = $this->orderAdapter->fromArray($obj['order']);
        $deal->landing     = $this->landingPageAdapter->fromArray($obj['landing']);
        $deal->customer    = $this->customerAdapter->fromArray($obj['customer']);
        $deal->campaign    = $this->campaignAdapter->fromArray($obj['campaign']);
        $deal->fbcContext  = $this->contextAdapter->fromArray($obj['fbcContext']);
        $deal->twitContext = $this->contextAdapter->fromArray($obj['twitContext']);
        $deal->pintContext = $this->contextAdapter->fromArray($obj['pintContext']);

        if (isset($obj['leads']))
        {
            $leads = array();
            foreach ($obj['leads'] as $leadProps)
            {
                array_push($leads, $this->leadsAdapter->fromArray($leadProps));
            }
            $deal->leads = $leads;
        }

        return $deal;
    }
}
