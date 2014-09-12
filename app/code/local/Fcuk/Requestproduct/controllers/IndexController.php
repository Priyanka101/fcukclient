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
	public function getrequestFormAction(){
		/*echo 'asd';exit;*/
		$layout = $this->loadLayout();
		//print_r($block = $this->getLayout()->createBlock('fcuk_requestproduct/requestproduct')->setTemplate('requestproduct/requestproduct.phtml')->toHtml());
		$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',
		array('template' => 'preorder/requestproduct.phtml'));
		echo $block->toHtml();
	}
	public function getOutofstockFormAction(){

		$layout = $this->loadLayout();
		// print_r($block = $this->getLayout()->createBlock('fcuk_requestproduct/requestproduct')->setTemplate('requestproduct/requestproduct.phtml')->toHtml());
		$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',
		array('template' => 'requestproduct/requestproduct.phtml'));
		echo $block->toHtml();
	}
	
	public function getrequestSaveAction(){
		
		$postData =$this->getRequest()->getParams();
		//print_r($postData['user_data']);
		$arrayValue=$postData['user_data'];
		foreach($arrayValue as $array){
			$pData[]=$array['value'];
		}
	//	var_dump($pData);
		//print_r($pData);
		$insertArray = array();
		$insertArray['firstname'] =$pData[0];
		$insertArray['lastname'] =$pData[1];
		$insertArray['address'] =$pData[2];
		$insertArray['city'] =$pData[3];
		$insertArray['email'] =$pData[4];
		$insertArray['phoneno'] =$pData[5];
		$insertArray['productname'] =$pData[6];
		$insertArray['stylecode'] =$pData[7];
		$insertArray['size'] =$pData[8];
		$insertArray['color'] =$pData[9];

		$customer_name=$insertArray['firstname']." ".$insertArray['lastname'];
		//print_r($insertArray);exit;
		
		$model = Mage::getModel('requestproduct/requestmodel');
		$model->setData($insertArray);
		$model->save();
		 	 
		$modeldata = Mage::getModel('requestproduct/requestmodel')->getCollection()->getData();
		//print_r($modeldata);exit;
		$mail = Mage::getModel('core/email');
		$mail->setToName($insertArray['name']);
		$mail->setToEmail('supriya.lokhande@bmindia.com');
		$mail->setBody('Request for Product with ID: '.$insertArray['stylecode']);
		$mail->setSubject('Request for Product ID:'.$insertArray['stylecode']);
		$mail->setFromEmail($insertArray['email']);
		$mail->setFromName('Request for Product from:'." ".$customer_name);
		$mail->setType('html');// YOu can use Html or text as Mail format
		//$message = $this->__('Your Request for Product is successfully Submitted');
		//Mage::getSingleton('core/session')->addSuccess($message);
	
		try {
		$mail->send();
		Mage::getSingleton('core/session')->addSuccess('Your Request for Product is successfully Submitted');
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

		 	 /*
		 
		 -------------------- Contact Us--------------------
		 Input:Takes form data and send email
		 @send email to the autherative person of the website
		 ---------------------------------------------------

		 */
		 
		 public function contactusAction(){
	//	echo 'hi';
		
		$postData =$this->getRequest()->getParams();

		//print_r($postData);exit;

		$arrayValue=$postData['user_data'];
		foreach($arrayValue as $array){
		$pData[]=$array['value'];
		}
		//var_dump($pData);
	/*	$count=count($pData);
		echo $count;*/
		$insertArray = array();
		
		$insertArray['mailtitle'] =$pData[0];
		$insertArray['ordernumber'] =$pData[1];
		$insertArray['yourcomment'] =$pData[2];
		$insertArray['title'] =$pData[3];
		$insertArray['firstname'] =$pData[4];
		$insertArray['lastname'] =$pData[5];
		
		$insertArray['address'] =$pData[6];
		$insertArray['telephone'] =$pData[7];

		$insertArray['email'] ='manoj.chowrasiya@iksula.com';
		// print_r($insertArray);exit;
		if($insertArray['firstname']!=''){
			$customer_name=$insertArray['title'].'. '.$insertArray['firstname']." ".$insertArray['lastname'];
		}
		else{
			$customer_name='';
		}
		
		$content='<div>
					<p>'.$customer_name.' Contacted French Connection Regarding '.$insertArray['mailtitle'].'
					<p>Topic  : '.$insertArray['mailtitle'].'</p>
					<p><p>Order No  : '.$insertArray['ordernumber'].'</p>
					<p><p>Comment  : '.$insertArray['yourcomment'].'</p>
					<p><p>Name  : '.$customer_name.'</p>
					<p><p>Adress  : '.$insertArray['address'].'</p>
					<p>Telephone No  : '.$insertArray['telephone'].'</p>
				  </div>';
		$mail = Mage::getModel('core/email');
		$mail->setToName($insertArray['firstname']);
		$mail->setToEmail('supriya.lokhande@bmindia.com');
		//$mail->setToEmail('manoj.chowrasiya@iksula.com');
		$mail->setBody($content);
		$mail->setSubject('Contacted French Connection Regarding : '.$insertArray['mailtitle']);
		$mail->setFromEmail('contactus@frenchconnection.in');
		$mail->setFromName('Contact Us By:'." ".$customer_name);
		$mail->setType('html');// YOu can use Html or text as Mail format
		$message = $this->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.');
		Mage::getSingleton('core/session')->addSuccess($message);
	
		try {
		$mail->send();
		echo Mage::getSingleton('core/session')->addSuccess('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.');
		echo "mail sent";
		$this->_redirect("*/*/");
		//$this->_redirect();
		}
		catch (Exception $e) {
		Mage::getSingleton('core/session')->addError('Unable to send Email.');
		echo "not snet";


		
		 }
	}
	}


