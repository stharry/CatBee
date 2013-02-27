<?php
/**
 * Class Tribzi_Catbee_Helper_Data
 * @author  Yaniv Aran-Shamir
 */
require_once('CatBeeClient.php');

class Tribzi_Catbee_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_SETTINGS = 'tribzi/settings/';

    private function getCatBeeClient()
    {
        $apiServer = $this->getApiServer();

        $catBeeClient = new CatBeeClient();
        $catBeeClient->setServer($apiServer);

        $storeId = $this->getStoreConfig('Store_Id');
        $adapterId = $this->getStoreConfig('Adpter_Id');
        $catBeeClient->setShop($storeId, $adapterId);

        Mage::log('Tribzi client created. server: '.$apiServer.' shop: '.$storeId.' adapter: '.$adapterId);
        return $catBeeClient;
    }

    public function _getCouponString()
    {
        return 'trb' . Mage::helper('core')->getRandomString(8);
    }

    public function getCampaigns()
    {
        $mageArray[] = array('value' => '',
                             'label' => '<none>');

        $c = $this->getStoreConfig('Store_Id');
        $d = $this->getStoreConfig('Adpter_Id');
        if (!$c || !$d)
        {
            return $mageArray;
        }

        $campaigns = $this->getCatBeeClient()->getCampaigns();

        if ($campaigns)
        {
            try
            {
                Mage::log('Tribzi campaigns: '.$campaigns);

                $arr = Mage::helper('core')->jsonDecode($campaigns);


                foreach ($arr as $campaign)
                {
                    $mageArray[] = array('value' => $campaign['code'],
                                         'label' => $campaign['description']);
                }
            }
            catch (Exception $e)
            {
                return $mageArray;
            }
            return $mageArray;
        }

        return null;
    }

    public function setStoreConfig($key, $value)
    {
        $path = self::XML_PATH_SETTINGS . $key;
        Mage::getModel('core/config')->saveConfig($path, $value);

    }

    public function getStoreConfig($key,
        $storeId = Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID)
    {
        $path = self::XML_PATH_SETTINGS . $key;

        return Mage::getStoreConfig($path, $storeId);
    }

    public function getApiServer()
    {
        $configApiPath = $this->getStoreConfig('api_Server');

        Mage::log('tribzi configured api server' . $configApiPath);

        if (!empty($configApiPath))
        {
            return $configApiPath;
        }

        $apiServer =
            !empty($_SERVER['HTTPS'])
                ? 'https://api.tribzi.com'
                : 'http://api.tribzi.com';

        return $apiServer;
    }

    public function getCampaign($id)
    {
        $campaignCoupons = $this->getCatBeeClient()->getDiscounts($id);

        if ($campaignCoupons)
        {
            $arr = Mage::helper('core')->jsonDecode($campaignCoupons);
        }

        return $arr;
    }


}

