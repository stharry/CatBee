<?php

class JsonCampaignDiscountAdapter implements IModelAdapter
{

    public function toArray($obj)
    {
        $result = array();
        foreach ($obj as $discount)
        {
            $discountProps = array(
                'code' => $discount->code,
                'val'  => $discount->value,
                'abs'  => $discount->isAbsolute,
                'due'  => $discount->expirationDate,
                'cnt'  => $discount->useCount);

            array_push($result, $discountProps);

        }

        return $result;
    }

    public function fromArray($obj)
    {
        // TODO: Implement fromArray() method.
    }
}
