<?php
class Fcuk_Requestproduct_Block_Adminhtml_Request_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("requestproduct_form", array("legend"=>Mage::helper("requestproduct")->__("Item information")));

				
						$fieldset->addField("requestproduct_id", "text", array(
						"label" => Mage::helper("requestproduct")->__("Id"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "requestproduct_id",
						));
					
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("requestproduct")->__("name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("requestproduct")->__("email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("phoneno", "text", array(
						"label" => Mage::helper("requestproduct")->__("phoneno"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "phoneno",
						));
					
						$fieldset->addField("productid", "text", array(
						"label" => Mage::helper("requestproduct")->__("productid"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "productid",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getRequestData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getRequestData());
					Mage::getSingleton("adminhtml/session")->setRequestData(null);
				} 
				elseif(Mage::registry("request_data")) {
				    $form->setValues(Mage::registry("request_data")->getData());
				}
				return parent::_prepareForm();
		}
}
