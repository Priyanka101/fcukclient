<?php
class Fcuk_Outwardregister_Block_Adminhtml_Outwardregister extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_outwardregister';
    $this->_blockGroup = 'outwardregister';
    $this->_headerText = Mage::helper('outwardregister')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('outwardregister')->__('Add Item');
    parent::__construct();
  }
}