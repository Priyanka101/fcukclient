<?php
class Fcuk_Subscription_Block_Adminhtml_Subscription_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("subscription_form", array("legend"=>Mage::helper("subscription")->__("Item information")));

				
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("subscription")->__("email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("mobileno", "text", array(
						"label" => Mage::helper("subscription")->__("mobileno"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "mobileno",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getSubscriptionData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getSubscriptionData());
					Mage::getSingleton("adminhtml/session")->setSubscriptionData(null);
				} 
				elseif(Mage::registry("subscription_data")) {
				    $form->setValues(Mage::registry("subscription_data")->getData());
				}
				return parent::_prepareForm();
		}
}
