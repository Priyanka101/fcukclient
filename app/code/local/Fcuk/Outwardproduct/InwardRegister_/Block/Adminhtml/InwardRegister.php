<?php
class Fcuk_InwardRegister_Block_Adminhtml_InwardRegister extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_inwardregister';
    $this->_blockGroup = 'inwardregister';
    $this->_headerText = Mage::helper('inwardregister')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('inwardregister')->__('Add Item');
    parent::__construct();
  }
}