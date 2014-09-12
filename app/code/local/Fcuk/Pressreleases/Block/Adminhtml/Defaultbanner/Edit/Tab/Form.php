<?php
class Fcuk_Pressreleases_Block_Adminhtml_Defaultbanner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("pressreleases_form", array("legend"=>Mage::helper("pressreleases")->__("Item information")));

								
						$fieldset->addField('default_banner', 'image', array(
						'label' => Mage::helper('pressreleases')->__('Banner Image'),
						'name' => 'default_banner',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getDefaultbannerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getDefaultbannerData());
					Mage::getSingleton("adminhtml/session")->setDefaultbannerData(null);
				} 
				elseif(Mage::registry("defaultbanner_data")) {
				    $form->setValues(Mage::registry("defaultbanner_data")->getData());
				}
				return parent::_prepareForm();
		}
}
