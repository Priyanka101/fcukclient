<?php
class CommerceStack_Recommender_Block_System_Config_Form_Apikey extends Mage_Adminhtml_Block_System_Config_Form_Field
{  
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    { 
        $dataHelper = Mage::helper('recommender');
        $json = $dataHelper->getApiKeyAsJson();

        $element->setValue($json);

        return parent::_getElementHtml($element);
    }
    
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getElementHtml($element);
        return $html;
    }
}