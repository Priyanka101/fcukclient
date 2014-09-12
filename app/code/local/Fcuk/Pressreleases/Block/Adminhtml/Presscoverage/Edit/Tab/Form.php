<?php
class Fcuk_Pressreleases_Block_Adminhtml_Presscoverage_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("pressreleases_form", array("legend"=>Mage::helper("pressreleases")->__("Item information")));

				
						$fieldset->addField("title", "text", array(
						"label" => Mage::helper("pressreleases")->__("Title"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "title",
						));
									
						$fieldset->addField('image', 'textarea', array(
						'label' => Mage::helper('pressreleases')->__('Coverage Images'),
						'name' => 'image',
						'note' => 'enter comma separated names of images',
						));
						
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
						$fieldset->addField('new_date', 'date', array(
							'name' => 'new_date',
							'label' => Mage::helper('pressreleases')->__('select coverage date'),
							'title' => Mage::helper('pressreleases')->__('select coverage date'),
							'image' => $this->getSkinUrl('images/grid-cal.gif'),
							'input_format' => $dateFormatIso,
							'format' => $dateFormatIso,
							'time' => true
						));
						
						$fieldset->addField("imagetitle", "text", array(
						"label" => Mage::helper("pressreleases")->__("Image title"),
						"name" => "imagetitle",
						'note' => 'enter comma separated Title of images in the same order of image names',
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPresscoverageData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPresscoverageData());
					Mage::getSingleton("adminhtml/session")->setPresscoverageData(null);
				} 
				elseif(Mage::registry("presscoverage_data")) {
				    $form->setValues(Mage::registry("presscoverage_data")->getData());
				}
				return parent::_prepareForm();
		}
}
