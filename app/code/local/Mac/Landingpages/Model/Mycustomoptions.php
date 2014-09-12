<?php 
class Mac_Landingpages_Model_Mycustomoptions
{
    public function toOptionArray()
    {
        return array(
	               array('value' => 'home', 'label'=>Mage::helper('adminhtml')->__('Home')),
                 array('value' => 'home2', 'label'=>Mage::helper('adminhtml')->__('Home 2')),
	               array('value' => 'home3', 'label'=>Mage::helper('adminhtml')->__('Home 3')),
	               array('value' => 'man', 'label'=>Mage::helper('adminhtml')->__('Man')),
	               array('value' => 'woman', 'label'=>Mage::helper('adminhtml')->__('Woman')),
            	   array('value' => 'newin', 'label'=>Mage::helper('adminhtml')->__('New In')),
                 array('value' => 'underwear', 'label'=>Mage::helper('adminhtml')->__('Underwear')),
                 array('value' => 'sale', 'label'=>Mage::helper('adminhtml')->__('Sale')),
                     
                     
        );
    }
}
