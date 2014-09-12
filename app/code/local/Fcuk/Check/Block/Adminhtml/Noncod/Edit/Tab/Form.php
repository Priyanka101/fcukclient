<?php
class Fcuk_Check_Block_Adminhtml_Noncod_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("check_form", array("legend"=>Mage::helper("check")->__("Item information")));

				
						$fieldset->addField("pincode", "text", array(
						"label" => Mage::helper("check")->__("pincode"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "pincode",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("check")->__("city"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "city",
						));
					
						$fieldset->addField("location", "text", array(
						"label" => Mage::helper("check")->__("location"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "location",
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("check")->__("state"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "state",
						));
					
						$fieldset->addField("ncod", "text", array(
						"label" => Mage::helper("check")->__("ncod"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "ncod",
						));
					
						$fieldset->addField("zone", "text", array(
						"label" => Mage::helper("check")->__("zone"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "zone",
						));
						$fieldset->addField("eastzone", "text", array(
						"label" => Mage::helper("check")->__("East Zone"),					
						//"class" => "required-entry",
						"required" => false,
						"name" => "eastzone",
						));
						 $fieldset->addField('filename', 'file', array(
						'label'     => Mage::helper('check')->__('File'),
						'required'  => false,
						'name'      => 'filename',
						));
						
						 $fieldset->addField('carrier', 'text', array(
						'label'     => Mage::helper('check')->__('Carrier'),
						'required'  => false,
						'name'      => 'carrier',
						));

				if (Mage::getSingleton("adminhtml/session")->getNoncodData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getNoncodData());
					Mage::getSingleton("adminhtml/session")->setNoncodData(null);
				} 
				elseif(Mage::registry("noncod_data")) {
				    $form->setValues(Mage::registry("noncod_data")->getData());
				}
				return parent::_prepareForm();
		}
}
