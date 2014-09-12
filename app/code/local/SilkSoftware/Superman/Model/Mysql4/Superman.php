<?php
class SilkSoftware_Superman_Model_Mysql4_Superman extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("superman/superman", "customer_id");
    }
}