<?php
class Fcuk_InwardRegister_Block_InwardRegister extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getInwardRegister()     
     { 
        if (!$this->hasData('inwardregister')) {
            $this->setData('inwardregister', Mage::registry('inwardregister'));
        }
        return $this->getData('inwardregister');
        
    }
}