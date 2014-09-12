<?php

class Fcuk_Outwardproduct_Block_Adminhtml_Outwardproduct_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('outwardproduct_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('outwardproduct')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('outwardproduct')->__('Item Information'),
          'title'     => Mage::helper('outwardproduct')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('outwardproduct/adminhtml_outwardproduct_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}