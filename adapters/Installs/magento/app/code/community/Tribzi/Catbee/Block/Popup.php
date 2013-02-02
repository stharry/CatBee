<?php
/**
 * Class Tribzi_Catbee_Popup
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Block_Popup extends Mage_Core_Block_Template
{
  protected function _beforeToHtml() {
    if ($params = Mage::getSingleton('checkout/session')->getData('catbee')) {
      $uriPrefix = !empty($_SERVER['HTTPS']) ? 'https://api.tribzi.com/' : 'http://api.tribzi.com/';
      $paramsStr = 'id=' . $params['id'] . '&to=' . $params['subTotal'] . '&cn=' . $params['name']
          . '&ce=' . $params['email'].'&shop=2&adpt=54c5e6c3-6349-11e2-a702-0008cae720a7';
      $src = $uriPrefix .  'CatBee/adapters/Installs/catbeepostpurchase.js?reload&' . $paramsStr;
      $this->setScript($src);
      Mage::getSingleton('checkout/session')->unsetData('catbee');
    }
  }
}

