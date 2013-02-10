<?php

class JsonLeadsAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        return array(
            'to'        => $obj->to,
            'reward'    => $obj->landingRewardId,
            'id'        => $obj->id,
            'uid'       => $obj->uid,
            'shareType' => $obj->shareType,
            'orderId'   => $obj->orderId,
            'status'    => $obj->status,
            'orders'    => $obj->referralOrders,
            'impressions' => $obj->impressions
        );

    }

    public function fromArray($obj)
    {
        $lead = new ShareLead();

        $lead->to              = $obj['to'];
        $lead->landingRewardId = $obj['reward'];
        $lead->id              = $obj['id'];
        $lead->uid             = $obj['uid'];
        $lead->shareType       = $obj['shareType'];
        $lead->orderId         = $obj['orderId'];
        $lead->status          = $obj['status'];
        $lead->referralOrders  = $obj['orders'];
        $lead->impressions = $obj['impressions'];

        return $lead;
    }
}
