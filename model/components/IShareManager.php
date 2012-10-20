<?php

interface IShareManager
{
    public function share($share);

    public function setShareTemplate($shareTemplate);

    public function getShareTemplates($shareFilter);

    public function getContacts($shareNode);

    public function requiresAuthentication($shareNode);

    public function getAuthenticationUrl($shareNode, $params);
}
