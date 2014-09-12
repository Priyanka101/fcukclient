<?php
class SilkSoftware_Superman_Block_Adminhtml_Superman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("superman_form", array("legend"=>Mage::helper("superman")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("superman")->__("customer name"),
						"name" => "name",
						));
					
						$fieldset->addField("lastname", "text", array(
						"label" => Mage::helper("superman")->__("last name "),
						"name" => "lastname",
						));
					
						$fieldset->addField("address", "textarea", array(
						"label" => Mage::helper("superman")->__("address"),
						"name" => "address",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("superman")->__("city "),
						"name" => "city",
						));
					
						$fieldset->addField("zip", "text", array(
						"label" => Mage::helper("superman")->__("zip "),
						"name" => "zip",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("superman")->__("email "),
						"name" => "email",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("superman")->__("mobile "),
						"name" => "mobile",
						));
					
						$fieldset->addField("product_name", "text", array(
						"label" => Mage::helper("superman")->__("product name "),
						"name" => "product_name",
						));
					
						$fieldset->addField("sku", "text", array(
						"label" => Mage::helper("superman")->__("sku "),
						"name" => "sku",
						));
					
						$fieldset->addField("size", "text", array(
						"label" => Mage::helper("superman")->__("size "),
						"name" => "size",
						));
					
						$fieldset->addField("color", "text", array(
						"label" => Mage::helper("superman")->__("color "),
						"name" => "color",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getSupermanData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getSupermanData());
					Mage::getSingleton("adminhtml/session")->setSupermanData(null);
				} 
				elseif(Mage::registry("superman_data")) {
				    $form->setValues(Mage::registry("superman_data")->getData());
				}
				return parent::_prepareForm();
		}
}
