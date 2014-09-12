<?php
class Fcuk_Outwardproduct_Block_Adminhtml_Outwardproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_outwardproduct';
    $this->_blockGroup = 'outwardproduct';
    $this->_headerText = Mage::helper('outwardproduct')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('outwardproduct')->__('Add Item');
    parent::__construct();
  }
}