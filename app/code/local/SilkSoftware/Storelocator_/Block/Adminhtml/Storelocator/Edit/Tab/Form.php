<?php
class SilkSoftware_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("storelocator_form", array("legend"=>Mage::helper("storelocator")->__("Item information")));

				
						$fieldset->addField("store", "editor", array(
						"label" => Mage::helper("storelocator")->__("store "),
						"name" => "store",
						"wysiwyg" => true,
						"required" => true,
						"config" => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
						));
					
						$fieldset->addField("address", "editor", array(
						"label" => Mage::helper("storelocator")->__("address "),					
						"class" => "required-entry",
						"name" => "address",
						"style" => "width:700px; height:320px;",
						"wysiwyg" => true,
						"required" => true,
						"config" => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("storelocator")->__("city "),
						"name" => "city",
						));
					
						/* $fieldset->addField("state", "text", array(
						"label" => Mage::helper("storelocator")->__("state "),
						"name" => "state",
						)); */
					
						$fieldset->addField("pincode", "text", array(
						"label" => Mage::helper("storelocator")->__("pin code"),
						"name" => "pincode",
						));
					
						$fieldset->addField("tel_number", "text", array(
						"label" => Mage::helper("storelocator")->__("telephone number"),
						"name" => "tel_number",
						));
						
						/* $fieldset->addField("lattlong", "text", array(
						"label" => Mage::helper("storelocator")->__("lattitude longitude"),
						"name" => "lattlong",
						)); */
					

				if (Mage::getSingleton("adminhtml/session")->getStorelocatorData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getStorelocatorData());
					Mage::getSingleton("adminhtml/session")->setStorelocatorData(null);
				} 
				elseif(Mage::registry("storelocator_data")) {
				    $form->setValues(Mage::registry("storelocator_data")->getData());
				}
				return parent::_prepareForm();
		}
}
