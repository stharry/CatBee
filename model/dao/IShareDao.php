<?php

interface IShareDao
{
    public function getShareTemplates($shareFilter);

    public function insertShareTemplate($shareTemplate);

    public function insertOrUpdateShareTemplate($shareTemplate);

    public function IsShareTemplateExists($shareTemplate);
}
