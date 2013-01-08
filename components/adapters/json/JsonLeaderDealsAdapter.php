<?php

class JsonLeaderDealsAdapter implements IModelAdapter
{

    private $dealAdapter;

    function __construct()
    {
        $this->dealAdapter = new JsonLeaderDealAdapter();
    }
    public function toArray($obj)
    {
        $deals = array();

        foreach ($obj as $deal)
        {
            array_push($deals, $this->dealAdapter->toArray($deal));
        }
        return $deals;
    }

    public function fromArray($obj)
    {
        // TODO: Implement fromArray() method.
    }
}
