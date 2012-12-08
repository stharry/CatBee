<?php

interface IRestrictionsManager
{
    public function getValidOrderItems($order);

    public function saveRestrictions($campaign);

    public function getRestrictions($campaign);
}
