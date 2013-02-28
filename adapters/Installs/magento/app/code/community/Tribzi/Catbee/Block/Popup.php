<?php
/**
 * Class Tribzi_Catbee_Popup
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Popup extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        Mage::log('Tribzi_Catbee_Block_Popup _beforeToHtml');
        if ($params = Mage::getSingleton('checkout/session')->getData('catbee'))
        {
            Mage::log('Tribzi_Catbee_Block_Popup constructing widget');

            $inlinePP = "
  window.cbWidgets.postPurchaseWidget(".json_encode($params).");";

            $this->setScript($inlinePP);
            Mage::getSingleton('checkout/session')->unsetData('catbee');
        }
    }
}

