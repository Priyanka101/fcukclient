<?php
class Iksula_Campaign_Block_Adminhtml_Campaign_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("campaign_form", array("legend"=>Mage::helper("campaign")->__("Item information")));

				
						$fieldset->addField("campaign_id", "hidden", array(
						"label" => Mage::helper("campaign")->__("Id"),
						"name" => "campaign_id",
						));
					
						$fieldset->addField("email_address", "text", array(
						"label" => Mage::helper("campaign")->__("Email"),
						"name" => "email_address",
						));
					
						$fieldset->addField("prefix", "text", array(
						"label" => Mage::helper("campaign")->__("Prefix"),
						"name" => "prefix",
						));
					
						$fieldset->addField("firstname", "text", array(
						"label" => Mage::helper("campaign")->__("First Name"),
						"name" => "firstname",
						));
					
						$fieldset->addField("lastname", "text", array(
						"label" => Mage::helper("campaign")->__("Last Name"),
						"name" => "lastname",
						));
									
						 $fieldset->addField('gender', 'select', array(
						'label'     => Mage::helper('campaign')->__('Gender'),
						'values'   => Iksula_Campaign_Block_Adminhtml_Campaign_Grid::getValueArray5(),
						'name' => 'gender',
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('customerdob', 'date', array(
						'label'        => Mage::helper('campaign')->__('Date of Birth'),
						'name'         => 'customerdob',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("telephoneno", "text", array(
						"label" => Mage::helper("campaign")->__("Telephone"),
						"name" => "telephoneno",
						));
					
						$fieldset->addField("mobileno", "text", array(
						"label" => Mage::helper("campaign")->__("Mobile"),
						"name" => "mobileno",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getCampaignData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCampaignData());
					Mage::getSingleton("adminhtml/session")->setCampaignData(null);
				} 
				elseif(Mage::registry("campaign_data")) {
				    $form->setValues(Mage::registry("campaign_data")->getData());
				}
				return parent::_prepareForm();
		}
}
