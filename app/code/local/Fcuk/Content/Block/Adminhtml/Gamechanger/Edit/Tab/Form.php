<?php
class Fcuk_Content_Block_Adminhtml_Gamechanger_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("content_form", array("legend"=>Mage::helper("content")->__("Item information")));

								
						 $fieldset->addField('slideno', 'select', array(
						'label'     => Mage::helper('content')->__('Slide No'),
						'values'   => Fcuk_Content_Block_Adminhtml_Gamechanger_Grid::getValueArray1(),
						'name' => 'slideno',
						));				
						 $fieldset->addField('type', 'select', array(
						'label'     => Mage::helper('content')->__('Banner Type'),
						'values'   => Fcuk_Content_Block_Adminhtml_Gamechanger_Grid::getValueArray2(),
						'name' => 'type',
						));
						$fieldset->addField("name1", "text", array(
						"label" => Mage::helper("content")->__("Name 1"),
						"name" => "name1",
						));
					
						$fieldset->addField("name2", "text", array(
						"label" => Mage::helper("content")->__("Name 2"),
						"name" => "name2",
						));
					
						$fieldset->addField("name3", "text", array(
						"label" => Mage::helper("content")->__("Name 3"),
						"name" => "name3",
						));
					
						$fieldset->addField("name4", "text", array(
						"label" => Mage::helper("content")->__("Name 4"),
						"name" => "name4",
						));
					
						$fieldset->addField("name5", "text", array(
						"label" => Mage::helper("content")->__("Name 5"),
						"name" => "name5",
						));
					
						$fieldset->addField("name6", "text", array(
						"label" => Mage::helper("content")->__("Name 6"),
						"name" => "name6",
						));
					
						$fieldset->addField("url1", "text", array(
						"label" => Mage::helper("content")->__("URL 1"),
						"name" => "url1",
						));
					
						$fieldset->addField("url2", "text", array(
						"label" => Mage::helper("content")->__("URL 2"),
						"name" => "url2",
						));
					
						$fieldset->addField("url3", "text", array(
						"label" => Mage::helper("content")->__("URL 3"),
						"name" => "url3",
						));
					
						$fieldset->addField("url4", "text", array(
						"label" => Mage::helper("content")->__("URL 4"),
						"name" => "url4",
						));
					
						$fieldset->addField("url5", "text", array(
						"label" => Mage::helper("content")->__("URL 5"),
						"name" => "url5",
						));
					
						$fieldset->addField("url6", "text", array(
						"label" => Mage::helper("content")->__("URL 6"),
						"name" => "url6",
						));
									
						$fieldset->addField('image1', 'image', array(
						'label' => Mage::helper('content')->__('Image 1'),
						'name' => 'image1',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('image2', 'image', array(
						'label' => Mage::helper('content')->__('Image 2'),
						'name' => 'image2',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('image3', 'image', array(
						'label' => Mage::helper('content')->__('Image 3'),
						'name' => 'image3',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('image4', 'image', array(
						'label' => Mage::helper('content')->__('Image 4'),
						'name' => 'image4',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('image5', 'image', array(
						'label' => Mage::helper('content')->__('Image 5'),
						'name' => 'image5',
						'note' => '(*.jpg, *.png, *.gif)',
						));				
						$fieldset->addField('image6', 'image', array(
						'label' => Mage::helper('content')->__('Image 6'),
						'name' => 'image6',
						'note' => '(*.jpg, *.png, *.gif)',
						));

				if (Mage::getSingleton("adminhtml/session")->getGamechangerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getGamechangerData());
					Mage::getSingleton("adminhtml/session")->setGamechangerData(null);
				} 
				elseif(Mage::registry("gamechanger_data")) {
				    $form->setValues(Mage::registry("gamechanger_data")->getData());
				}
				return parent::_prepareForm();
		}
}
