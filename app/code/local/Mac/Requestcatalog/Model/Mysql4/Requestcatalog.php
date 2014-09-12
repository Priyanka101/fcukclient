<?php
class Mac_Requestcatalog_Model_Mysql4_Requestcatalog extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("requestcatalog/requestcatalog", "id");
    }
}