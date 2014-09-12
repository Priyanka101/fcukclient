<?php
class Osdave_OrdersGrid_Block_Adminhtml_Sales_Order_Renderer_ShippingMethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$shippingMethod = $row->getShippingMethod();
		$shippingMethodCode = explode('_', $shippingMethod);
		$shippingMethod = Mage::getStoreConfig('carriers/' . $shippingMethodCode[0] . '/title');
		
		return $shippingMethod;
	}
}