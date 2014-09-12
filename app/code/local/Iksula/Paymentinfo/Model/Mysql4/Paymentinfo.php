<?php
class Iksula_Paymentinfo_Model_Mysql4_Paymentinfo extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("paymentinfo/paymentinfo", "payment_info_id");
    }
}