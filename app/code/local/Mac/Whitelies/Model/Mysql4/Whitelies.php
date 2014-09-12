<?php
class Mac_Whitelies_Model_Mysql4_Whitelies extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("whitelies/whitelies", "id");
    }
}