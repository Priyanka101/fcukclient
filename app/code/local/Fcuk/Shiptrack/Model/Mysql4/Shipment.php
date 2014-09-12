<?php
class Fcuk_Shiptrack_Model_Mysql4_Shipment extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("shiptrack/shipment", "s_id");
    }
}