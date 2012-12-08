<?php

class RestrictionsManager implements IRestrictionsManager
{
    private $validatorsFactory;
    private $restrictionsDao;

    function __construct($validatorsFactory, $restrictionsDao)
    {
        $this->validatorsFactory = $validatorsFactory;
        $this->restrictionsDao = $restrictionsDao;

    }

    public function getValidOrderItems($order)
    {
        $restrictions =
            $this->restrictionsDao->getCampaignRestrictionsByActiveShareId($order->activeShareId);

        $items = $order->items;

        foreach ($restrictions as $restriction)
        {
            $validator = $this->validatorsFactory
                ->createRestrictionsValidator($restriction);

            if (!$validator->isOrderValid($order))
            {
                $order->status->code = $restriction->code;
                $order->status->description = $restriction->description;
                return false;
            }


            $validItems = array();
            foreach ($items as $item)
            {
                if ($validator->isItemValid($item))
                {
                    array_push($validItems, $item);
                }
            }
            $items = $validItems;

            if (count($items) == 0)
            {
                $order->status->code = $restriction->code;
                $order->status->description = $restriction->description;
                return false;
            }
        }

        return $items;
    }

    public function saveRestrictions($campaign)
    {
        $this->restrictionsDao->deleteCampaignRestrictions($campaign);

        $this->restrictionsDao->saveCampaignRestrictions($campaign);
    }

    public function getRestrictions($campaign)
    {
        return $this->restrictionsDao->getCampaignRestrictionsByCampaignId($campaign->id);
    }
}
