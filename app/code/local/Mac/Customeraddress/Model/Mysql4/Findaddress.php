<?php
class Mac_Customeraddress_Model_Mysql4_Findaddress extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("customeraddress/findaddress", "id");
    }
}