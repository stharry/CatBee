<?php
/**
 * Class Tribzi_Catbee_Footerscripts
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Footerscripts extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        Mage::log('Tribzi_Catbee_Block_Footerscripts _beforeToHtml');

        $uriPrefix = Mage::helper('Tribzi_Catbee')->getApiServer();
        $shopId = Mage::helper('Tribzi_Catbee')->getStoreConfig('Store_Id');

        $srcs[ ] = $uriPrefix . '/CatBee/public/res/js/min/catbeeframe.js';
        $srcs[ ] = $uriPrefix . '/CatBee/adapters/Installs/shops/'.$shopId.'/cbfdefaults.js';
        $this->setScripts($srcs);
    }
}

