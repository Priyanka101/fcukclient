<?php
class Mac_Custom_Model_Mysql4_Kittedout extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("custom/kittedout", "id");
    }
}