<?php
class Iksula_Campaign_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
        
    	  $this->loadLayout();   
    	  $this->getLayout()->getBlock("head")->setTitle($this->__("Campaign"));
    	  $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
          $breadcrumbs->addCrumb("home", array(
                    "label" => $this->__("Home Page"),
                    "title" => $this->__("Home Page"),
                    "link"  => Mage::getBaseUrl()
    		   ));

          $breadcrumbs->addCrumb("campaign", array(
                    "label" => $this->__("Campaign"),
                    "title" => $this->__("Campaign")
    		   ));

          $this->renderLayout(); 
	  
    }

    Public function postValuesAction(){
      $data = $this->getRequest()->getPost();
      if(!Mage::helper('customer')->isLoggedIn()){
        $this->_initLayoutMessages('core/session');
        $this->saveInCampaign($data);              
        $this->_redirectUrl(Mage::getBaseURl().'campaign/index/thankyou');
        return;
      }else{
        $this->sendEmail($data);
        $this->_redirectUrl(Mage::getBaseURl().'campaign/index/thankyou');
        return;
      }

    }
     

    public function saveInCampaign($data){
      
      $campaign = Mage::getModel('campaign/campaign');
      $campaign->setData($data);
      $campaign->setEmailAddress($data['email']);
      $campaign->setCustomerdob($data['dob']);
      $campaign->save();
      
    }
    public function thankyouAction(){
        $this->loadLayout();   
        $this->getLayout()->getBlock("head")->setTitle($this->__("Campaign"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
           ));

        $breadcrumbs->addCrumb("campaign", array(
                "label" => $this->__("Campaign"),
                "title" => $this->__("Campaign")
           ));

        $this->renderLayout(); 
    }

    public function sendEmail($data){
        $email = $data['email'];
        $fname = $data['firstname'];
        $lName = $data['lastname'];
        $templateId = 6;
        try {

            $sender = array('name' => 'French Connection',
            'email' => 'customercare@frenchconnection.in');
            //recepient
            $vars = array('cust_name'=>$fname,'cust_email'=>$email);
            //$vars = Array('customVar'=>$yourvarialbe);
            $storeId = Mage::app()->getStore()->getId();
            $translate = Mage::getSingleton('core/translate');
            Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $email, $fname, $vars, $storeId);
            $translate->setTranslateInline(true);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return $errorMessage;
        }

    }
}