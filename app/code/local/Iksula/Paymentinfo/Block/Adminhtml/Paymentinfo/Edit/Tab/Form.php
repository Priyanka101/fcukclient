<?php
class Iksula_Paymentinfo_Block_Adminhtml_Paymentinfo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("paymentinfo_form", array("legend"=>Mage::helper("paymentinfo")->__("Item information")));

				
						$fieldset->addField("payment_info_id", "text", array(
						"label" => Mage::helper("paymentinfo")->__("Payment Info ID"),
						"name" => "payment_info_id",
						));
					
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("paymentinfo")->__("Payment Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("payment_type", "text", array(
						"label" => Mage::helper("paymentinfo")->__("Payment Method Type"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "payment_type",
						));
					
						$fieldset->addField("price", "text", array(
						"label" => Mage::helper("paymentinfo")->__("Price"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "price",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPaymentinfoData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPaymentinfoData());
					Mage::getSingleton("adminhtml/session")->setPaymentinfoData(null);
				} 
				elseif(Mage::registry("paymentinfo_data")) {
				    $form->setValues(Mage::registry("paymentinfo_data")->getData());
				}
				return parent::_prepareForm();
		}
}
