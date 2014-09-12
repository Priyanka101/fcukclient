<?php
class Fcuk_Pressreleases_Model_Mysql4_Defaultbanner extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("pressreleases/defaultbanner", "banner_id");
    }
}