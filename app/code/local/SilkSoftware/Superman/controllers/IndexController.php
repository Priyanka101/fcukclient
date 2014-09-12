<?php
class SilkSoftware_Superman_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("preorder"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("preorder", array(
                "label" => $this->__("preorder"),
                "title" => $this->__("preorder")
		   ));

      $this->renderLayout(); 
	  
    }
	public function getrequestSaveAction(){
		
		$postData =$this->getRequest()->getParams();
		//print_r($postData['user_data']);exit;
		$arrayValue=$postData['user_data'];
		foreach($arrayValue as $array){
			$pData[]=$array['value'];
		}
		$insertArray = array();
		$insertArray['name'] =$pData[0];
		$insertArray['lastname'] =$pData[1];
		$insertArray['address'] =$pData[2];
		$insertArray['city'] =$pData[3];
		$insertArray['email'] =$pData[4];
		$insertArray['mobile'] =$pData[5];
		$insertArray['product_name'] =$pData[6];
		$insertArray['sku'] =$pData[7];
		$insertArray['size'] =$pData[8];
		$insertArray['color'] =$pData[9];

		$customer_name=$insertArray['name']." ".$insertArray['lastname'];
		//print_r($insertArray);exit;
		
		$model = Mage::getModel('superman/superman');
		$model->setData($insertArray);
		$model->save();
		 	 
		$modeldata = Mage::getModel('superman/superman')->getCollection()->getData();
		//print_r($modeldata);exit;
		$mail = Mage::getModel('core/email');
		$mail->setToName($insertArray['name']);
		$mail->setToEmail('supriya.lokhande@bmindia.com');
		$mail->setBody('Request for Product with ID: '.$insertArray['sku'].'<br/>customer name :'.$insertArray['name'].'<br/>contact no :'.$insertArray['mobile']);
		$mail->setSubject('Request for Product ID:'.$insertArray['sku']);
		$mail->setFromEmail($insertArray['email']);
		$mail->setFromName('Request for Product from:'." ".$customer_name);
		$mail->setType('html');// YOu can use Html or text as Mail format
		//$message = $this->__('Your Request for Product is successfully Submitted');
		//Mage::getSingleton('core/session')->addSuccess($message);
	
		try {
		$mail->send();
		Mage::getSingleton('core/session')->addSuccess('Your Request for superman Product is successfully Submitted');
		echo "mail sent";
		//$this->_redirect();
		}
		catch (Exception $e) {
		Mage::getSingleton('core/session')->addError('Unable to send Email.');
		echo "not snet";
		//$this->_redirect();
		}
		//$message = $this->__('Your Request for Product is successfully Submitted');
		//Mage::getSingleton('core/session')->addSuccess($message);
	 
	//	$this->_redirect("*/*/");
	

		
		 }
}