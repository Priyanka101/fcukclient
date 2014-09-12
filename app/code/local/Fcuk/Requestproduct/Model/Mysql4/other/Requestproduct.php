    <?php
     
    class Fcuk_Requestproduct_Model_Mysql4_Requestproduct extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
        {   
            $this->_init('Requestproduct/Requestproduct', 'Requestproduct_id');
        }
    }