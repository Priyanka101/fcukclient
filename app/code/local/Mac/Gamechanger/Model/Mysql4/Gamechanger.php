<?php
class Mac_Gamechanger_Model_Mysql4_Gamechanger extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("gamechanger/gamechanger", "id");
    }
}