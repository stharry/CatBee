<?php

class TribziShareProvider implements IShareProvider
{

    public function share($share)
    {
        // TODO: Implement share() method.
        return true;
    }

    public function getContacts($customer)
    {
        // TODO: Implement getContacts() method.
    }

    public function requiresAuthentication($shareNode)
    {
        return false;
        // TODO: Implement requiresAuthentication() method.
    }

    public function getAuthenticationUrl($shareNode, $params)
    {
        // TODO: Implement getAuthenticationUrl() method.
    }

    public function getCurrentSharedCustomer()
    {
        // TODO: Implement getCurrentSharedCustomer() method.
    }
}
