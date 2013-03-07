<?php

class JsonLeaderDealFilterAdapter implements IModelAdapter
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

        $DealFilter           = new LeaderDealFilter();
        $DealFilter->customer = $this->customerAdapter->fromArray($obj["Customer"]);

        $DealFilter->initDateBiggerThen  = $obj["initDateBiggerThen"];
        $DealFilter->Campaign            = $obj["Campaign"];
        $DealFilter->initDateEarlierThen = $obj["initDateEarlierThen"];
        $DealFilter->ReferralsFlag       = $obj["ReferralsFlag"];
        $DealFilter->ImpressionFlag      = $obj["ImpressionFlag"];

        if ($obj["ActiveShareType"] == "all")
        {
            $DealFilter->FillAllActiveShareTypes();
        }
        else
        {
            $ShareType = new ShareType($obj["ActiveShareType"]);
            $DealFilter->AddToShareTypeArray($ShareType);

        }

        return $DealFilter;
    }

}
