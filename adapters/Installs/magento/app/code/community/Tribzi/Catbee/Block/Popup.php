<?php
/**
 * Class Tribzi_Catbee_Popup
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Popup extends Mage_Core_Block_Template
{
    protected function _beforeToHtml()
    {
        if ($params = Mage::getSingleton('checkout/session')->getData('catbee'))
        {

            $appendTo = trim(Mage::helper('Tribzi_Catbee')->getStoreConfig('append_To'));
            $setBefore = trim(Mage::helper('Tribzi_Catbee')->getStoreConfig('set_Before'));

            $guiParams = array();
            if (!empty($appendTo))
            {
                $guiParams["appendTo"] = $appendTo;
            }
            if (!empty($setBefore))
            {
                $guiParams["setBefore"] = $setBefore;
            }

            $guiParams["closeButton"] = true;

            $inlinePP = "
  window.cbWidgets.postPurchaseWidget(".json_encode($params).",".json_encode($guiParams).");";

            $this->setScript($inlinePP);
            Mage::getSingleton('checkout/session')->unsetData('catbee');
        }
    }
}

