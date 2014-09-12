<?php
class Fcuk_Requestproduct_Model_Mysql4_Request extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("requestproduct/request", "requestproduct_id");
    }
}