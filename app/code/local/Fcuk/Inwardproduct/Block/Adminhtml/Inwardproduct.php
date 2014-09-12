<?php
class Fcuk_Inwardproduct_Block_Adminhtml_Inwardproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_inwardproduct';
    $this->_blockGroup = 'inwardproduct';
    $this->_headerText = Mage::helper('inwardproduct')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('inwardproduct')->__('Add Item');
    parent::__construct();
  }
}