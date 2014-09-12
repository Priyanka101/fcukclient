    <?php
     
    class Fcuk_Requestproduct_Model_Mysql4_Requestproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {
        public function _construct()
        {
            //parent::__construct();
            $this->_init('requestproduct/requestmodel');
        }
    }