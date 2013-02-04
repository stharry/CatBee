<?php
/**
 * Class Tribzi_Catbee_Footerscripts
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Footerscripts extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        $uriPrefix = !empty($_SERVER[ 'HTTPS' ]) ? 'https://api.tribzi.com/' : 'http://api.tribzi.com/';
        //TODO: make this configurable via layout.xml
        $srcs[ ] = $uriPrefix . 'CatBee/adapters/Installs/catbeeframe.js';
        $srcs[ ] = $uriPrefix . 'CatBee/adapters/Installs/catbeecart.js?cfid=coupon_code';
        $this->setScripts($srcs);
    }
}

