<?php

class Fcuk_Inwardproduct_Block_Adminhtml_Inwardproduct_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('inwardproduct_form', array('legend'=>Mage::helper('inwardproduct')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('inwardproduct')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('inwardproduct')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('inwardproduct')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('inwardproduct')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('inwardproduct')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('inwardproduct')->__('Content'),
          'title'     => Mage::helper('inwardproduct')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getInwardproductData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInwardproductData());
          Mage::getSingleton('adminhtml/session')->setInwardproductData(null);
      } elseif ( Mage::registry('inwardproduct_data') ) {
          $form->setValues(Mage::registry('inwardproduct_data')->getData());
      }
      return parent::_prepareForm();
  }
}