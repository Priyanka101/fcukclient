<?php
class Osdave_OrdersGrid_Block_Adminhtml_Sales_Order_Filter_PaymentMethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected function _getOptions()
    {
	    $methods = array(array('label' => '', 'value' => null));
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();

		foreach ($payments as $paymentCode => $paymentModel) {
			$paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');
			$methods[] = array('label' => $paymentTitle, 'value' => $paymentCode);
		}

		return $methods;
	}
}