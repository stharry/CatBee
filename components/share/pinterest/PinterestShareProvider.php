<?php

class PinterestShareProvider implements IShareProvider
{

    public function share($share)
    {
        return true;
    }

    public function getContacts($customer)
    {
        // TODO: Implement getContacts() method.
    }

    public function requiresAuthentication($shareNode)
    {
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
