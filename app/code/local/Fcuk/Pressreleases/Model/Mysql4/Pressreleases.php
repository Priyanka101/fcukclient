<?php
class Fcuk_Pressreleases_Model_Mysql4_Pressreleases extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("pressreleases/pressreleases", "release_id");
    }
}