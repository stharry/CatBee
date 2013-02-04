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
      $paramsStr = http_build_query($params);
      $src = $uriPrefix .  'CatBee/adapters/Installs/catbeepostpurchase.js?' . $paramsStr;
      $this->setScript($src);
      Mage::getSingleton('checkout/session')->unsetData('catbee');
    }
  }
}

