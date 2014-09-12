<?php
class Fcuk_Shippingvalidation_Block_Adminhtml_Shippingvalidation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_shippingvalidation';
    $this->_blockGroup = 'shippingvalidation';
    $this->_headerText = Mage::helper('shippingvalidation')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('shippingvalidation')->__('Add Item');
    parent::__construct();
  }
}