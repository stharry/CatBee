<?php

interface IAdaptorDao
{
    public function isAdaptorExists($adaptor);

    public function loadAdaptor($adaptor);

    public function loadAdaptorById($adaptor);

    public function insertAdaptor($adaptor);

}
