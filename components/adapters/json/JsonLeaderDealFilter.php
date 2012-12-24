<?php

class JsonLeaderDealFilter implements IModelAdapter
{
    private $customerAdapter;

    function __construct()
    {
        $this->customerAdapter = new JsonCustomerAdapter();

    }
    public function toArray($obj)
    {

    }
    public function fromArray($obj)
    {
        $DealFilter = new LeaderDealFilter();
        $DealFilter->customer = $this->customerAdapter->fromArray($obj["Customer"]);
        $DealFilter->initDateBiggerThen =  $obj["initDateBiggerThen"];
        $DealFilter->initDateEarlierThen =  $obj["initDateEarlierThen"];
        return $DealFilter;
    }

}
