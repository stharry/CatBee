<?php
/**
 * Class Tribzi_Catbee_Adminhtml_CatbeeAdminController
 * @author  Yaniv Aran-Shamir
 */
class Tribzi_Catbee_Adminhtml_CatbeeadminController extends Mage_Adminhtml_Controller_Action
{
  public function indexAction()
  {
    $this->loadLayout();
    $this->renderLayout();
  }

  public function saveAction()
  {
    $post = $this->getRequest()->getPost();
    foreach ($post as $key => $value){
      Mage::helper('Tribzi_Catbee')->setStoreConfig($key, $value);
    }


    $campaign = Mage::helper('Tribzi_Catbee')->getCampaign($post['campaign']);
    $this->create_coupon($campaign);
    $this->_redirectReferer();
  }


  public function create_coupon($post)
  {
    if (!empty($post)) {
      $default_values = array(
        'website_ids' => array(1),
        'customer_group_ids' => array(0),
        'name' => 'Tribzi coupon',
        'from_date' => NULL,
        'to_data' => NULL,
        'product_ids' => NULL,
        'coupon_type' => 2,
        'is_active' => 1,
        'uses_per_coupon' => 1, //TBD
        'uses_per_customer' => 1, //TBD
        'rule' => array(
          'conditions' => array(
            array(
              'type' => 'catalogrule/rule_condition_combine',
              'aggregator' => 'all',
              'value' => 1,
              'new_child' => NULL,
            ),
            'actions' => array(
              array(
                'type' => 'salesrule/rule_condition_product_combine',
                'aggregator' => 'all',
                'value' => 1,
                'new_child' => NULL,
              )
            ),
          )
        ),
        'simple_action' => $post['type'],
        'apply_to_shipping' => 0,
        'simple_free_shipping' => 0,
        'stop_rules_processing' => 0,
        'store_labels' => array('Trizbi created coupon'),
      );
      $range = $post['max'] - $post['min'];
      $step = $range / $post['qty'];
      $max = (int) $post['max'];
      $nextStep = (int) $post['min'];
      while ($nextStep <= $max) {
        $data = $default_values;
        $data['coupon_code'] = Mage::helper('Tribzi_Catbee')->_getCouponString();
        $data['discount_amount'] = $nextStep;
        $this->_createCoupon($data);
        $couponCodes[] = $data['coupon_code'];
        $nextStep = $nextStep + $step;
      }

    }
  }

  private function _createCoupon($data)
  {
    $model = Mage::getModel('salesrule/rule');
    $data = $this->_filterDates($data, array('from_date', 'to_date'));
    $validateResult = $model->validateData(new Varien_Object($data));
    if ($validateResult == true) {
      if (isset($data['simple_action']) && $data['simple_action'] == 'by_percent'
        && isset($data['discount_amount'])) {
          $data['discount_amount'] = min(100, $data['discount_amount']);
        }
      if (isset($data['rule']['conditions'])) {
        $data['conditions'][1] = $data['rule']['conditions'];
      }
      if (isset($data['rule']['actions'])) {
        $data['actions'][1] = $data['rule']['actions'];
      }
      unset($data['rule']);
      $model->loadPost($data);
      $model->save();

    }


  }
}

