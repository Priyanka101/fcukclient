<?php
class Fcuk_Check_Model_Mysql4_Noncod extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("check/noncod", "ncod_id");
    }
}