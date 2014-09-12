<?php
class Fcuk_Requestproduct_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Request Froduct"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("request froduct", array(
                "label" => $this->__("Request Froduct"),
                "title" => $this->__("Request Froduct")
		   ));

      $this->renderLayout(); 
	  
    }
	public function getrequestSaveAction(){
		//$postData = $_REQUEST[];
	//	echo '<pre>';
	//	echo $_REQUEST['name'];
	//	print_r($postData);
		//exit;
		$insertArray = array();
		$insertArray['name'] =$_REQUEST['name'];
		$insertArray['email'] =$_REQUEST['email'];
		$insertArray['phoneno'] =$_REQUEST['phoneno'];
		$insertArray['productid'] ='1234';
		
		  $collection = Mage::getModel('requestproduct/requestproduct')->getCollection();
		  var_dump($collection);
			foreach($collection as $category) {
			if($category->getId() == $id) {
             echo "it has been founnnd!!!";

         }
     }
		
		// $model = Mage::getModel('requestproduct/requestproduct');
		// foreach ($insertArray as $entityid) {
		// $model->query( "INSERT INTO requestproduct('name','email','phoneno','productid')
		// VALUES ( '.$_REQUEST[name].','fffff', 99999, 1)" );
		// }
}
	//	var_dump($_REQUEST);
	//var_dump($insertArray);

	//echo '<pre>';
   // print_r($model);exit;
	/*
			try {
				//$mail->send(); //Function to send email
				$brandsModel = Mage::getModel("requestproduct/requestproduct")
				->addData($insertArray)
				->save();
				//echo "data saved";
				echo true;
			}
			catch (Exception $e) {
				echo false;
			}
	*/
	/*
		if ($postData) {
			$insertArray = array();
			$insertArray['name'] =$_REQUEST['name'];
			$insertArray['email'] =$_REQUEST['email'];
			$insertArray['phoneno'] =$_REQUEST['phoneno'];
			$insertArray['productid'] ='1234';//$_REQUEST['productid'];
		*/	
		//	print_r($insertArray);
			
			 /*Code to send email in magento Start*/
			$mail = Mage::getModel('core/email');
			$mail->setToName($_REQUEST['name']);
			$mail->setToEmail($_REQUEST['email']);
			$mail->setBody('Request send successfully');
			$mail->setSubject('Request for Product');
		
			$mail->setFromName("Fcuk");
			$mail->setType('html');
			
			try {
				$mail->send(); //Function to send email
				$brandsModel = Mage::getModel("requestproduct/requestproduct")
				->addData($insertArray)
				->save();
				echo true;
			}
			catch (Exception $e) {
				echo false;
			}
		} else{
			echo false;
		}
	//}
}

