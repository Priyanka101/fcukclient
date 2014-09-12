<?php
class Fcuk_Requestproduct_Model_Mysql4_Requestmodel extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("requestproduct/requestmodel", "requestproduct_id");
    }
}