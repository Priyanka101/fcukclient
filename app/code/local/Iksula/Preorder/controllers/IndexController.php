<?php
class Iksula_Preorder_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

	  // $this->loadLayout();
	  // $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	  //       $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
   //    $breadcrumbs->addCrumb("home", array(
   //              "label" => $this->__("Home Page"),
   //              "title" => $this->__("Home Page"),
   //              "link"  => Mage::getBaseUrl()
		 //   ));

   //    $breadcrumbs->addCrumb("titlename", array(
   //              "label" => $this->__("Titlename"),
   //              "title" => $this->__("Titlename")
		 //   ));

   //    $this->renderLayout();
      $entries = $this->getRequest()->getParams();
       $model = Mage::getModel('preorder/preorder');
       $model->setData($entries)->save();
       // $replymsg="Thank you for your valuable feedback. We will get back to you!!";
       $modeldata = Mage::getModel('requestproduct/requestmodel')->getCollection()->getData();
    //print_r($modeldata);exit;
      $mail = Mage::getModel('core/email');
      $mail->setToName($entries['customer_firstname']);
      $mail->setToEmail('supriya.lokhande@bmindia.com');
      $mail->setBody('Request for Product with ID: '.$entries['product_sku']);
      $mail->setSubject('Request for Product ID:'.$entries['product_sku']);
      $mail->setFromEmail($entries['customer_email']);
      $mail->setFromName('Request for Product from:'." ".$entries['customer_firstname']. " " . $entries['customer_lastname']);
      $mail->setType('html');// YOu can use Html or text as Mail format
      //$message = $this->__('Your Request for Product is successfully Submitted');
      //Mage::getSingleton('core/session')->addSuccess($message);

      try {
      $mail->send();
      Mage::getSingleton('core/session')->addSuccess('Your Request for Product is successfully Submitted');
      $response = "mail sent";
      //$this->_redirect();
      }
      catch (Exception $e) {
      Mage::getSingleton('core/session')->addError('Unable to send Email.');
      $response = "not snet";
      //$this->_redirect();
      }
      return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

    }

    public function MihirAction(){
      $entries = $this->getRequest()->getParams();
       $model = Mage::getModel('preorder/preorder');
       $model->setData($entries)->save();
       // $replymsg="Thank you for your valuable feedback. We will get back to you!!";
       $modeldata = Mage::getModel('requestproduct/requestmodel')->getCollection()->getData();
    //print_r($modeldata);exit;
      $mail = Mage::getModel('core/email');
      $mail->setToName("mihir");
      $mail->setToEmail('shaily.a@iksula.com');
      $mail->setBody('Request for Product with ID: '."abcd");
      $mail->setSubject('Request for Product ID:'."abcd");
      $mail->setFromEmail("mihir.bhende@iksula.com");
      $mail->setFromName('Request for Product from:'." Mihir Bhende");
      $mail->setType('html');// YOu can use Html or text as Mail format
      //$message = $this->__('Your Request for Product is successfully Submitted');
      //Mage::getSingleton('core/session')->addSuccess($message);

      try {
      $mail->send();
      Mage::getSingleton('core/session')->addSuccess('Your Request for Product is successfully Submitted');
      $response = "mail sent";
      //$this->_redirect();
      }
      catch (Exception $e) {
      Mage::getSingleton('core/session')->addError('Unable to send Email.');
      $response = "not snet";
      //$this->_redirect();
      }
    }
}
