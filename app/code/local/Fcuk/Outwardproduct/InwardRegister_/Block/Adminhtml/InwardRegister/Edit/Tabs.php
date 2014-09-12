<?php

class Fcuk_InwardRegister_Block_Adminhtml_InwardRegister_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('inwardregister_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('inwardregister')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('inwardregister')->__('Item Information'),
          'title'     => Mage::helper('inwardregister')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('inwardregister/adminhtml_inwardregister_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}