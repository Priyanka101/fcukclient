<?php
class Osdave_OrdersGrid_Block_Adminhtml_Sales_Order_Renderer_PaymentMethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$paymentMethodCode = $row->getPaymentMethod();
		$paymentTitle = Mage::getStoreConfig('payment/' . $paymentMethodCode . '/title');
		
		return $paymentTitle;
	}
}