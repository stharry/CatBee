<?php

class JsonShareFilterAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        // TODO: Implement toArray() method.
    }

    public function fromArray($obj)
    {
        $shareFilter = new ShareFilter();
        if ($obj['context'])
        {
            $contextAdapter = new JsonShareContextAdapter();
            $shareFilter->context = $contextAdapter->fromArray($obj['context']);
        }
        return $shareFilter;
    }
}
