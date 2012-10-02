<?php

interface IShareManager
{
    public function share($share);

    public function setShareTemplate($shareTemplate);

    public function getShareTemplates($shareFilter);
}
