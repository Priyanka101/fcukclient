<?php
class Fcuk_Check_Model_Mysql4_Cod extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("check/cod", "cod_id");
    }
}