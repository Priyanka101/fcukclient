<?php
class Fcuk_Inwardregister_Block_Adminhtml_Inwardregister extends Mage_Adminhtml_Block_Widget_Grid_Container
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