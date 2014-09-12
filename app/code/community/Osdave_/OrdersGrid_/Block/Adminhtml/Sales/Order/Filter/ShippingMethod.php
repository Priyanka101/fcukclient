<?php
class Osdave_OrdersGrid_Block_Adminhtml_Sales_Order_Filter_ShippingMethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected function _getOptions()
    {
	    $methods = array(array('label' => '', 'value' => null));
        $shippingMethods = Mage::getModel('adminhtml/system_config_source_shipping_allmethods')
                                    ->toOptionArray();

        foreach ($shippingMethods as $key => $shipping) {
            $isActive = Mage::getStoreConfig('carriers/' . $key . '/active');
            if ($isActive) {
                foreach ($shipping['value'] as $method) {
                    $methods[] = array('label' => $method['label'], 'value' => $method['value']);
                }
            }
        }

        return $methods;

    }
}