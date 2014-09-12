<?php
class Iksula_Preorder_Model_Mysql4_Preorder extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("preorder/preorder", "preorder_id");
    }
}