<?php
class Fcuk_Inwardregister_Block_Inwardregister extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getInwardregister()     
     { 
        if (!$this->hasData('inwardregister')) {
            $this->setData('inwardregister', Mage::registry('inwardregister'));
        }
        return $this->getData('inwardregister');
        
    }
}