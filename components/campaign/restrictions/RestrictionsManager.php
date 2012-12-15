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

        RestLogger::log('RestrictionsManager::getValidOrderItems begin', $restrictions);

        $items = $order->items;

        foreach ($restrictions as $restriction)
        {
            $validator = $this->validatorsFactory
                ->createRestrictionsValidator($restriction);

            if (!$validator->isOrderValid($order))
            {
                $order->status->code = $restriction->code;
                $order->status->description = $restriction->description;

                RestLogger::log('RestrictionsManager::getValidOrderItems Order not valid for '.$restriction->name);
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
                RestLogger::log('RestrictionsManager::getValidOrderItems no valid items for '.$restriction->name);
                return false;
            }
        }

        RestLogger::log('RestrictionsManager::getValidOrderItems end', $items);

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
