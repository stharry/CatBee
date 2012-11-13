<?php

interface IDealShareDao
{
    public function addDealShare($share);

    public function updateDealShare($share);

    public function fillDealShareById($share);
}
