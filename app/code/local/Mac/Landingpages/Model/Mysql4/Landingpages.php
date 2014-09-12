<?php
class Mac_Landingpages_Model_Mysql4_Landingpages extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("landingpages/landingpages", "id");
    }
}