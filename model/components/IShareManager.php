<?php

interface IShareManager
{
    public function share($share);

    public function setShareTemplate($shareTemplate);

    public function getShareTemplates($shareFilter);

    public function getContacts($shareNode);

    public function fillShare($share);

    public function addDealShare($share);

    public function updateDealShare($share);

    public function requiresAuthentication($shareNode);

    public function getAuthenticationUrl($shareNode, $params);

    public function getCurrentSharedCustomer($context);

    public function addShareApplication($context);

    public function fillShareContext($deal, $context);
}
