<?php

interface IStoreDao
{
    public function isStoreExists($store);

    public function loadStore($store);

    public function insertStore($store);

    public function updateStore($store);

}
