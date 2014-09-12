<?php
class Fcuk_Shippingvalidation_Block_Shippingvalidation extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getShippingvalidation()     
     { 
        if (!$this->hasData('shippingvalidation')) {
            $this->setData('shippingvalidation', Mage::registry('shippingvalidation'));
        }
        return $this->getData('shippingvalidation');
        
    }
}