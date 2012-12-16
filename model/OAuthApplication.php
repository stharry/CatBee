<?php

// any web application (like facebook/shoppify/twitter) that uses Online Authorization 2 protocol
// must provide it;s parameters for sharing
class OAuthApplication
{
    public $id;
    public $context;
    public $oauthId;
    public $oauthKey;
    public $oauthSecret;
    public $oauthUrl;
    public $redirectUrl;

}
