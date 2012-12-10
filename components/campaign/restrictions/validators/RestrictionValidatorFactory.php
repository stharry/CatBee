<?php

class RestrictionValidatorFactory implements IRestrictionValidatorFactory
{

    public function createRestrictionsValidator($restriction)
    {

        $props = json_decode($restriction->expression, true);
        switch ($restriction->name)
        {
            case 'blackList':
                return new BlackListValidator($props['codes']);

            case 'whiteList':
                return new BlackListValidator($props);

            case 'amount':
                return new OrderTotalValidator($props['amount']);

            default:
                throw new Exception('Cannot find compatible validator for restriction '.$restriction->name);
        }
    }
}
