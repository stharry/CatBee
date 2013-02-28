<?php

class RewardsCalculator
{
    private $deal;
    private static $GIFT_CARD_AMOUNT_OFF = 'amount off gift';
    private static $GIFT_CARD = 'gift card';

    function __construct($deal)
    {
        $this->deal = $deal;
    }

    private function calculateReward($reward)
    {
        if (strtolower($reward->type) == RewardsCalculator::$GIFT_CARD_AMOUNT_OFF)
        {
            $reward->value = round($this->deal->amount / $reward->value * 100);
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
