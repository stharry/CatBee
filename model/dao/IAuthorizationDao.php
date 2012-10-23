<?php

interface IAuthorizationDao
{
    public function getAuthorization($shareNode);

    public function setAuthorization($shareNode, $shareAuthorization);

}
