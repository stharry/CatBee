<?php

class JsonTribeAdapter implements IModelAdapter
{
    private $customerAdapter;
    function __construct()
    {
        $this->customerAdapter    = new JsonCustomerAdapter();
    }
    private function singleTribeToArray($tribe)
    {

        $tribes = array(
            'id'              => $tribe->id,
            'TribeName'       => $tribe->TribeName,
            'customers'       => $this->customerAdapter->toArray($tribe->customers)
        );
        return $tribes;
    }
    public function toArray($obj)
    {
        if (is_array($obj))
        {
            $tribes = array();

            foreach ($obj as $tribe)
            {

                array_push($tribes, $this->singleTribeToArray($tribe));
            }
            return $tribes;
        }
        else
        {
            return $this->singleTribeToArray($obj);
        }
    }
    public function fromArray($obj)
    {
        $tribe = new Tribe();
        return $tribe;
    }
}
