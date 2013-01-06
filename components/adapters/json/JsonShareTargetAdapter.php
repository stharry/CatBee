<?php

class JsonShareTargetAdapter implements IModelAdapter
{
    private $contextAdapter;

    function __construct()
    {
        $this->contextAdapter = new JsonShareContextAdapter();
    }
    private function sentToFromArray($sendTo)
    {
        $result = array();

        foreach (explode(',', $sendTo) as $email)
        {
            $customer = new Customer($email);

            array_push($result, $customer);
        }
        return $result;
    }

    private function sentToToArray($sendTo)
    {
        $result = '';

        foreach ($sendTo as $customer)
        {
            $result .= $customer->email.',';

        }
        return $result;
    }

    public function toArray($obj)
    {
        return array(
            'name' => $obj->name,
            'from' => $obj->from->email,
            'to' => $this->sentToToArray($obj->to));
    }

    public function fromArray($obj)
    {
        if (isset($obj) && isset($obj[ 'name' ]))
        {
            $target = new ShareTarget($obj[ 'name' ]);
        }
        else
        {
            $target = new ShareTarget();
        }
        $target->from = new Customer($obj['from']);
        $target->to = $this->sentToFromArray($obj['to']);
        $target->context = $this->contextAdapter->fromArray($obj['context']);

        return $target;
    }
}
