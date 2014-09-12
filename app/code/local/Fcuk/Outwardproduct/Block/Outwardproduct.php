<?php
class Fcuk_Outwardproduct_Block_Outwardproduct extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOutwardproduct()     
     { 
        if (!$this->hasData('outwardproduct')) {
            $this->setData('outwardproduct', Mage::registry('outwardproduct'));
        }
        return $this->getData('outwardproduct');
        
    }
}