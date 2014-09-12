<?php
class Fcuk_Shiptrack_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Shiptrack"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("shiptrack", array(
                "label" => $this->__("Shiptrack"),
                "title" => $this->__("Shiptrack")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function AddtrackAction() {
	
	$carrier = $this->getRequest()->getPost('carrier');
	$method = $this->getRequest()->getPost('method');
	//echo $method;
	$carrier =$_REQUEST['carrier'];
 
//	$carrier ='bluedart';//$_REQUEST['carrier'];

	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');
	//$query = "SELECT * FROM shiptrack WHERE carrier= '".$carrier."' AND status='0'" ;
	if($method!='cashondelivery')
	{
	$query = "SELECT awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND ncod='1' LIMIT 0,1";
	//	echo $query;
	}
	else
	{		$query = "SELECT awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND cod='1' LIMIT 0,1";
	
		//echo $query;
	}
	
	$result=$read->query($query);
	$cod = $result->fetch();
	//echo mysql_num_rows($cod);
/* 	if(mysql_num_rows($cod)==0){
		
		echo 'No AWB Number found';
	}
	else
	{
	   */  
	   $awbnumber=$cod['awbnumber'];
		
		echo $awbnumber;
	
	//}
	}
	public function AddtrackgridAction() {
	
	$carrier = $this->getRequest()->getPost('carrier');
	$method = $this->getRequest()->getPost('method');
	//echo $method;
	$carrier =$_REQUEST['carrier'];
	$postalcode =  $this->getRequest()->getPost('postalcode'); 
 
//	$carrier ='bluedart';//$_REQUEST['carrier'];

	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');
	//$query = "SELECT * FROM shiptrack WHERE carrier= '".$carrier."' AND status='0'" ;
	
	if($method!='cashondelivery')
	{
	$checkpostal = "SELECT * FROM ncod WHERE carrier ='".$carrier."' AND pincode ='".$postalcode."'";
	$checkpostalresult=$read->query($checkpostal);
	$checkpostalvalue = $checkpostalresult->fetch();
	if(empty($checkpostalvalue)){
		return "";
	}
	 $query = "SELECT s_id , awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND ncod='1' and cod='0' and temp_status=0 LIMIT 0,1";
	//	echo $query;
	}
	else
	{	
	$checkpostal = "SELECT * FROM cod WHERE carrier ='".$carrier."' AND pincode ='".$postalcode."'";
	$checkpostalresult=$read->query($checkpostal);
	$checkpostalvalue = $checkpostalresult->fetch();
	if(empty($checkpostalvalue)){
		return "";
	}
	
		$query = "SELECT s_id , awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND cod='1' and ncod='0' and temp_status=0 LIMIT 0,1";
	
		//echo $query;
	}
	
	$result=$read->query($query);

	$cod = $result->fetch();

	// if(!empty($cod)){
	// echo $awbnumber=$cod['awbnumber'];
	// $query = "UPDATE shiptrack SET temp_status = 1 WHERE s_id =".$cod['s_id'];
	// $result=$read->query($query);
	// }

	if(!empty($cod)){

		$awbnumber=$cod['awbnumber'];
		/* start of awb number assigning on 5th august */
		$query = "select carrier from order_ship_track where track_no ='$awbnumber'";
		$resultnew=$read->query($query);
		$cod2 = $resultnew->fetchall();

		if(count($cod2)=='0'){
		 	echo $awbnumber=$cod['awbnumber'];
		 }
		else{
		 	$updateawbnumber = $this->UpdatetrackingnumberAction($awbnumber);
		 	echo $awbnumber = $this->AddtrackingnumberifusedAction($carrier,$postalcode,$method);
		 }
		//$query = "UPDATE shiptrack SET temp_status = 1 WHERE awbnumber =".$awbnumber;
		/* End of awb number assigning on 5th august */
		$query = "UPDATE shiptrack SET temp_status = 1 WHERE s_id =".$cod['s_id'];
		$result=$read->query($query);
	}
	
	}
	
	public function UpdatetempstatusAction(){
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');
	$query = "UPDATE shiptrack SET temp_status = 0";
	$result=$read->query($query);
	
	}
	
	public function UpdatetrackAction() {
	
	$track = $this->getRequest()->getPost('track');
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_write');
	
	$query = "UPDATE shiptrack SET status = 1 , temp_status = 0 WHERE awbnumber ='".$track."'";
	$result=$read->query($query);

	echo  "successfully updated";
	
	}
	/*
	* update AWB Number if it is used but not updated
	*
	*/
	
	public function UpdatetrackingnumberAction($track) {

		$resource = Mage::getSingleton('core/resource');
		$read = $resource->getConnection('core_write');

		$query = "UPDATE shiptrack SET status = 1 , temp_status = 0 WHERE awbnumber ='".$track."'";
		$result=$read->query($query);
		//echo  "successfully updated";

	}
	/*
	* Bring New AWB Number if it is used but used
	*
	*/
	public function AddtrackingnumberifusedAction($carrier,$postalcode,$method) {
		$resource = Mage::getSingleton('core/resource');
		$read = $resource->getConnection('core_read');
		if($method!='cashondelivery')
		{
			$checkpostal = "SELECT * FROM ncod WHERE carrier ='".$carrier."' AND pincode ='".$postalcode."'";
			$checkpostalresult=$read->query($checkpostal);
			$checkpostalvalue = $checkpostalresult->fetch();
			if(empty($checkpostalvalue)){
				return "";
			}
			$query = "SELECT s_id , awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND ncod='1' and cod='0' and temp_status='0' LIMIT 0,1";
		}
		else
		{	
			$checkpostal = "SELECT * FROM cod WHERE carrier ='".$carrier."' AND pincode ='".$postalcode."'";
			$checkpostalresult=$read->query($checkpostal);
			$checkpostalvalue = $checkpostalresult->fetch();
			if(empty($checkpostalvalue)){
				return "";
			}

			$query = "SELECT s_id , awbnumber FROM shiptrack WHERE carrier ='".$carrier."' AND status ='0' AND cod='1' and ncod='0' and temp_status='0' LIMIT 0,1";
		}

		$result=$read->query($query);
		$cod = $result->fetch();
		echo $cod['awbnumber'];
		$query = "UPDATE shiptrack SET temp_status = 1 WHERE s_id =".$cod['s_id'];
		$result=$read->query($query);		

	}
	public function OndeleteupdateAction() 
	{
	
	$trackid = $this->getRequest()->getPost('trackid');
//	$trackid=30;
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_write');
	
//	$query = "UPDATE shiptrack SET status = 0 WHERE awbnumber ='".$track."'";
	$query = "UPDATE shiptrack SET status='0' , temp_status = 0 where awbnumber =(SELECT track_number FROM sales_flat_shipment_track where entity_id='".$trackid."')";
	$result=$read->query($query);
	if($result!='')
	{
	echo  "successfully deleted updated";
	}
	else
	{
	echo "no data found";
	}
	}
	
	public function OndeleteAction() 
	{
	
	$trackid = $this->getRequest()->getPost('trackid');
//	$trackid=30;
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_write');
	
	$query = "UPDATE shiptrack SET status = 0 , temp_status = 0 WHERE awbnumber ='$trackid'";
	print_r($query);
	//$query = "UPDATE shiptrack SET status='0' where awbnumber =(SELECT track_number FROM sales_flat_shipment_track where entity_id='".$trackid."')";
	$result=$read->query($query);
	
	echo  "successfully deleted ";
	
	}
	
	/* Girish Code for delete trackid */
	//change two table shiptrack for status and order_ship_track for delete track no
	
	public function deleteTracknewAction(){
		$trackid = $this->getRequest()->getPost('trackno');
		
		$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_write');
	
	$query = "UPDATE shiptrack SET status = 0 , temp_status = 0 WHERE awbnumber = '$trackid'";
	$result=$read->query($query);
	
	$query = "delete from order_ship_track WHERE track_no = '$trackid'";
	$result=$read->query($query);
		
		echo $trackid;
	}
	
	
	
	
	
	
	
	public function newAction() 
	{
	
				$tracknumber = $this->getRequest()->getParam('track_numbers');
				
				$carrier = $this->getRequest()->getParam('carrier');
				
				echo $tracknumber." ".$carrier;
				//echo "hello world new 1";
			/* 	if($carrier=='quantium')
				{
				$layout = $this->loadLayout();
				$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',array('template' => 'sales/order/shippingtracking.phtml'));
				echo $block->toHtml();  */
				switch($carrier)
				{
					case 'quantium':
				Mage::getSingleton('core/session')->setTracknumber($tracknumber);
				$layout = $this->loadLayout();
				$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',array('template' => 'sales/order/shippingtracking.phtml'));
				echo $block->toHtml(); 
				break;
				
				case 'bluedart':
				Mage::getSingleton('core/session')->setTracknumber($tracknumber);
				$layout = $this->loadLayout();
				$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',array('template' => 'shipping/tracking/bluedart.phtml'));
				echo $block->toHtml(); 
				break;
				
				
				}
				
			
	}
      
}