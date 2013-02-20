<?php
/**
 * Class Tribzi_Catbee_Footerscripts
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Footerscripts extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        $uriPrefix = Mage::helper('Tribzi_Catbee')->getApiServer();

        $srcs[ ] = $uriPrefix . '/CatBee/adapters/Installs/catbeeframe.js?host='.$uriPrefix.'/CatBee/';
        $srcs[ ] = $uriPrefix . '/CatBee/adapters/Installs/catbeecart.js?cfid=coupon_code';
        $this->setScripts($srcs);
    }
}

