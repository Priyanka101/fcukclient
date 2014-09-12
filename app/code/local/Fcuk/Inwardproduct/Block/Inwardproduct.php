<?php
class Fcuk_Inwardproduct_Block_Inwardproduct extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getInwardproduct()     
     { 
        if (!$this->hasData('inwardproduct')) {
            $this->setData('inwardproduct', Mage::registry('inwardproduct'));
        }
        return $this->getData('inwardproduct');
        
    }
}