<?php
class Tribzi_Catbee_Block_Adminhtml_Form_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
    $this->_blockGroup = 'Tribzi_Catbee';
    $this->_controller = 'adminhtml_form';
    $this->_headerText = Mage::helper('Tribzi_Catbee')->__('Edit Form');
  }
}
