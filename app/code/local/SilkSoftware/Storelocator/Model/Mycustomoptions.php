<?php 
class SilkSoftware_Storelocator_Model_Mycustomoptions
{
    public function toOptionArray()
    {
         $resource = Mage::getSingleton('core/resource');
         $readConnection = $resource->getConnection('core_read');
         $query = "SELECT distinct(city) FROM storelocator";
         $results = $readConnection->fetchAll($query);
         $i = 0;
         foreach($results as $result) {
            $returnArray[$i]['label'] = $result['city'];
            $returnArray[$i]['value'] = strtolower($result['city']);
            $i++;
         }
         // echo "<pre>"; print_r($returnArray); exit;
        return $returnArray;
    }
}
