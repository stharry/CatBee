<?php

interface IShareProvider
{
    public function share($share);

    public function getContacts($customer);

}
