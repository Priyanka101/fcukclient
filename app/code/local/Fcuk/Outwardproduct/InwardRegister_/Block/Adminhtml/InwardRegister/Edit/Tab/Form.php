<?php

class Fcuk_InwardRegister_Block_Adminhtml_InwardRegister_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('inwardregister_form', array('legend'=>Mage::helper('inwardregister')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('inwardregister')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('inwardregister')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('inwardregister')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('inwardregister')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('inwardregister')->__('Content'),
          'title'     => Mage::helper('inwardregister')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getInwardRegisterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInwardRegisterData());
          Mage::getSingleton('adminhtml/session')->setInwardRegisterData(null);
      } elseif ( Mage::registry('inwardregister_data') ) {
          $form->setValues(Mage::registry('inwardregister_data')->getData());
      }
      return parent::_prepareForm();
  }
}