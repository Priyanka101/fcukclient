<?php
class Fcuk_Outwardregister_Block_Outwardregister extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOutwardregister()     
     { 
        if (!$this->hasData('outwardregister')) {
            $this->setData('outwardregister', Mage::registry('outwardregister'));
        }
        return $this->getData('outwardregister');
        
    }
}