<?php
class Fcuk_Pressreleases_Block_Adminhtml_Pressreleases_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("pressreleases_form", array("legend"=>Mage::helper("pressreleases")->__("Item information")));

				
						$fieldset->addField("release_name", "text", array(
						"label" => Mage::helper("pressreleases")->__("Release name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "release_name",
						));
					
						$fieldset->addField('blog', 'editor', array(
							'name'      => 'blog',
							'label'     => Mage::helper('pressreleases')->__('Blog'),
							'title'     => Mage::helper('pressreleases')->__('Blog'),
							'style'     => 'height:15em',
							'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
							'wysiwyg'   => true,
							'required'  => false,
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
						$fieldset->addField('new_date', 'date', array(
							'name' => 'new_date',
							'label' => Mage::helper('pressreleases')->__('select release date'),
							'title' => Mage::helper('pressreleases')->__('select release date'),
							'image' => $this->getSkinUrl('images/grid-cal.gif'),
							'input_format' => $dateFormatIso,
							'format' => $dateFormatIso,
							'time' => true
						));			
						$fieldset->addField('banner', 'image', array(
						'label' => Mage::helper('pressreleases')->__('Banner Image'),
						'name' => 'banner',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getPressreleasesData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPressreleasesData());
					Mage::getSingleton("adminhtml/session")->setPressreleasesData(null);
				} 
				elseif(Mage::registry("pressreleases_data")) {
				    $form->setValues(Mage::registry("pressreleases_data")->getData());
				}
				return parent::_prepareForm();
		}
}
