<?php
class Mac_Landingpages_Block_Adminhtml_Landingpages_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("landingpages_form", array("legend"=>Mage::helper("landingpages")->__("Item information")));

				
						$fieldset->addField("catname", "text", array(
						"label" => Mage::helper("landingpages")->__("Category Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "catname",
						));
					
						$fieldset->addField("imageposition", "text", array(
						"label" => Mage::helper("landingpages")->__("Image Position"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "imageposition",
						));
					
						$fieldset->addField("content", "textarea", array(
						"label" => Mage::helper("landingpages")->__("Content"),
						"name" => "content",
						));
									
						$fieldset->addField('bannerimage', 'image', array(
						'label' => Mage::helper('landingpages')->__('Banner Image'),
						'name' => 'bannerimage',
						'note' => '(*.jpg, *.png, *.gif)',
						));
						$fieldset->addField("url", "text", array(
						"label" => Mage::helper("landingpages")->__("URL"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "url",
						));
									
						$fieldset->addField('image', 'image', array(
						'label' => Mage::helper('landingpages')->__('Image'),
						'name' => 'image',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('video', 'image', array(
						'label' => Mage::helper('landingpages')->__('Video'),
						'name' => 'video',
						'note' => '(*.mp4)',
						));
						$fieldset->addField("css", "textarea", array(
						"label" => Mage::helper("landingpages")->__("CSS"),
						"name" => "css",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getLandingpagesData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getLandingpagesData());
					Mage::getSingleton("adminhtml/session")->setLandingpagesData(null);
				} 
				elseif(Mage::registry("landingpages_data")) {
				    $form->setValues(Mage::registry("landingpages_data")->getData());
				}
				return parent::_prepareForm();
		}
}
