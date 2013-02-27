<?php

class LeaderDealFilter
{
    public function FillAllActiveShareTypes()
    {
        $ShareTypeMail = new ShareType("email");
        $this->AddToShareTypeArray($ShareTypeMail);
        $ShareTypeFB = new ShareType("facebook");
        $this->AddToShareTypeArray($ShareTypeFB);
        $ShareTypeTwt = new ShareType("twitter");
        $this->AddToShareTypeArray($ShareTypeTwt);
        $ShareTypePnt = new ShareType("pinterest");
        $this->AddToShareTypeArray($ShareTypePnt);
        $ShareTypePnt = new ShareType("urlShare");
        $this->AddToShareTypeArray($ShareTypePnt);

    }
    public function AddToShareTypeArray($shareType)
    {
        array_push($this->ActiveShareType, $shareType);
    }
    public $customer;
    public $ReferralsFlag =false;
    public $ImpressionFlag = false;
    public $initDateBiggerThen;
    public $initDateEarlierThen;
    public $ActiveShareType = array();
    public $Campaign;

}
