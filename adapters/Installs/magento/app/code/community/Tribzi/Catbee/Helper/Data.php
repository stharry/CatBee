<?php
/**
 * Class Tribzi_Catbee_Helper_Data
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Helper_Data extends Mage_Core_Helper_Abstract
{
  const XML_PATH_SETTINGS = 'tribzi/settings/';
  const TRIBZI_BACKEND_BASE_URL = 'http://tribzi.local/';
  public function _getCouponString()
  {
    return 'trb' . Mage::helper('core')->getRandomString(8);
  }

  public function getCampaigns()
  {
    $client = new Varien_Http_Client(self::TRIBZI_BACKEND_BASE_URL . 'camp.json');
    $res = $client->request();
    if ($res->getStatus() == 200) {
      $arr = Mage::helper('core')->jsonDecode($res->getBody());
      foreach ($arr as $key => $value) {
        $mageArry[] = array('value' => $key, 'label' => $value);
      }
    }
    return $mageArry;

  }
  public function setStoreConfig ($key, $value)
  {
    $path = self::XML_PATH_SETTINGS . $key;
    Mage::getModel('core/config')->saveConfig($path, $value );

  }
  public function getStoreConfig ($key,
            $storeId = Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID)
    {
        $path = self::XML_PATH_SETTINGS . $key;
        return Mage::getStoreConfig($path, $storeId);
    }


  public function getCampaign($id)
  {
    $client = new Varien_Http_Client(self::TRIBZI_BACKEND_BASE_URL . $id . '.json');
    $res = $client->request();
    if ($res->getStatus() == 200) {
      $arr = Mage::helper('core')->jsonDecode($res->getBody());
    }
    return $arr;
  }




}

