<?php

class Fcuk_Shiptrack_Model_Shipment extends Mage_Core_Model_Abstract
{
    protected function _construct(){
       $this->_init("shiptrack/shipment");

    }
	
	public function onDeleteUpdate($trackId) {
   //$carrier =$_REQUEST['carrier'];
		
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');

	$query="SELECT track_number FROM sales_flat_shipment_track where entity_id='".$trackId."' LIMIT 0,1";
	//echo $query;
	$result=$read->query($query);
	$cod = $result->fetch();

	$awbnumber=$cod['track_number'];
	//echo $awbnumber;
	//	echo '<pre>';
	
	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	$query="UPDATE shiptrack SET status='0' where awbnumber='".$awbnumber."'";
	//echo $query;
	$result=$read->query($query);
	//$status = $result->save();
	
	/* 	exit;
	$data=array('status'='0');
	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	//$connection->beginTransaction();
	//$fields = array();
	//$fields['name'] = 'jony';

	$where = $connection->quoteInto('awbnumber=?',$awbnumber);
	$connection->update('shiptrack', $data, $where);
	$connection->save();   */ 
} 

}
	 