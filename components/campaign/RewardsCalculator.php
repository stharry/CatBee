<?php

class RewardsCalculator
{
    private $deal;
    private static $GIFT_CARD_AMOUNT_OFF = 'amount off gift';
    private static $GIFT_CARD = 'Gift Card';

    function __construct($deal)
    {
        $this->deal = $deal;
    }

    private function calculateReward($reward)
    {
        if (strtolower($reward->type) == RewardsCalculator::$GIFT_CARD_AMOUNT_OFF)
        {
            RestLogger::log('calculator '.$this->deal->order->amount.' val: '.$reward->value);
            $reward->value = max(round($this->deal->order->amount / 100 * $reward->value), 5);
            $reward->type = RewardsCalculator::$GIFT_CARD;
        }

    }

    public function calculateRewards($landingRewards)
    {
        foreach ($landingRewards as $landingReward)
        {
            $this->calculateReward($landingReward->leaderReward);
            $this->calculateReward($landingReward->friendReward);
        }
    }
}
