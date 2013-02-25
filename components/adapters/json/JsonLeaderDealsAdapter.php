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
            $dealProps = array(
                'id'       => $deal->id,
                'date'     => $deal->updateDate,
                'customer' => array(
                    'email'     => $deal->customer->email,
                    'firstName' => $deal->customer->firstName,
                    'lastName'  => $deal->customer->lastName,
                    'nickName'  => $deal->customer->nickName
                ),
                "leads"    => array()
            );

            foreach ($deal->leads as $lead)
            {
                $leadProps = array(
                    "id"         => $lead->id,
                    "status"     => $lead->status,
                    "orderId"    => $deal->order->id,
                    "shareType"  => ShareContext::id2Type($lead->shareType),
                    "referrals"  => array(),
                    "impression" => array()

                );

                foreach ($lead->impressions as $impression)
                {
                    $impressionProps = array(
                        "share" => $lead->id,
                        "ImpressionDate" => $impression

                    );

                    $leadProps["impression"][] = $impressionProps;
                }

                foreach ($lead->referralOrders as $refOrder)
                {
                    $refOrderProps = array(
                        "referalOrder" => $refOrder
                    );

                    $leadProps["referrals"][] = $refOrderProps;
                }
                $dealProps["leads"][] = $leadProps;
            }

            $deals[] = $dealProps;

        }

        return $deals;
    }

    public function fromArray($obj)
    {
        // TODO: Implement fromArray() method.
    }
}
