<?php
class Mac_Lookbook_Model_Mysql4_Lookbook extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("lookbook/lookbook", "id");
    }
}