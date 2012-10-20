<?php

interface IShareProvider
{
    public function share($share);

    public function getContacts($customer);

    public function requiresAuthentication($shareNode);

    public function getAuthenticationUrl($shareNode, $params);
}
