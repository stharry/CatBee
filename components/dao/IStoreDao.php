<?php

interface IStoreDao
{
    public function IsStoreExists($store);

    public function InsertStore($store);

    public function UpdateStore($store);

}
