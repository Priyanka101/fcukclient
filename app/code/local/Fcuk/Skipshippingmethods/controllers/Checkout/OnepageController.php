<?php

require_once 'Mage/Checkout/controllers/OnepageController.php';
class Fcuk_Skipshippingmethods_Checkout_OnepageController extends Mage_Checkout_OnepageController
{
 
 protected $_sectionUpdateFunctions = array(
    'payment-method' => '_getPaymentMethodsHtml',
    // 'shipping-method' => '_getShippingMethodsHtml',
    'review' => '_getReviewHtml',
);

public function saveBillingAction()
{
	
	
    if ($this->_expireAjax()) {
        return;
    }
    if ($this->getRequest()->isPost()) {
        $data = $this->getRequest()->getPost('billing', array());
        $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
        if (isset($data['email'])) {
            $data['email'] = trim($data['email']);
        
		}
		$method = 'freeshipping_freeshipping';
		Mage::getSingleton('checkout/type_onepage')->getQuote()->getShippingAddress()-> setShippingMethod($method)->save();
        $result = $this->getOnepage()->saveBilling($data, $customerAddressId);
		
		if (!isset($result['error'])) {
			if (!isset($result['error'])) {
				/* check quote for virtual */
				if ($this->getOnepage()->getQuote()->isVirtual()) {
					$result['goto_section'] = 'payment';
					$result['update_section'] = array(
					'name' => 'payment-method',
					'html' => $this->_getPaymentMethodsHtml()
					);
				}
				elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
					$result['allow_sections'] = array('shipping');
					$result['duplicateBillingInfo'] = 'true';
					$result['goto_section'] = 'payment';
				    $result['update_section'] = array(
					'name' => 'payment-method',
					'html' => $this->_getPaymentMethodsHtml()
					);
				}
				else {
					
					$result['goto_section'] = 'shipping';
					//$result['goto_section'] = 'payment';
				}
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
} 
  public function saveShippingAction()
    { 
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping', array());
            $customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
            $result = $this->getOnepage()->saveShipping($data, $customerAddressId);
			

            if (!isset($result['error'])) {
				$result['goto_section'] = 'payment';
				$result['update_section'] = array(
				'name' => 'payment-method',
				'html' => $this->_getPaymentMethodsHtml()
				);
			}
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

  
   /**
     * Shipping method save action
     */

    public function saveShippingMethodAction()
    {
	
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping_method', '');
			//$method = 'freeshipping_freeshipping';
			$result = $this->getOnepage()->saveShippingMethod('freeshipping');
			Mage::getSingleton('checkout/type_onepage')->getQuote()->getShippingAddress()-> setShippingMethod($method)->save();
            if(!$result) {
                Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
                        array('request'=>$this->getRequest(),
                            'quote'=>$this->getOnepage()->getQuote()));
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                
                if ($this->getOnepage()->getQuote()->getGrandTotal() == 0 && !$this->getOnepage()->getQuote()->hasRecurringItems()) {
                  $result = $this->getOnepage()->savePayment(array('method' => 'free'));
                  $this->loadLayout('checkout_onepage_review');
                  $result['goto_section'] = 'review';
                  $result['update_section'] = array(
                      'name' => 'review',
                      'html' => $this->_getReviewHtml()
                  );
                } else {

                  $result['goto_section'] = 'payment';
                 $result['update_section'] = array(
                     'name' => 'payment-method',
                      'html' => $this->_getPaymentMethodsHtml()
                  );
                }
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
    /**
     * Create order action
     */
    
  public function getRequestFormAction(){
	/*	
	echo '<form action="request.php" method="post">
			<ul class="form-list">
			<li class="control">
                    <div class="input-box-name">						
					<label class="required" for="login-email">Name<span>: *</span></label><input type="text" value="" name="login[username]" id="login-email-guest" class="input-text-register required-entry validate-email">
				    </div></br>
				 </li>
				 <li class="control">
                    <div class="input-box-email">						
					<label class="required" for="login-email">EmailAddress<span>: *</span></label><input type="text" value="" name="login[username]" id="login-email-guest" class="input-text-register required-entry validate-email">
				    </div></br>
				 </li><li class="control">
                    <div class="input-box-phoneno">						
					<label class="required" for="login-email">Phone No<span>: *</span></label><input type="text" value="" name="login[username]" id="login-email-guest" class="input-text-register required-entry validate-email">
				    </div></br>
				 </li><li class="control">
                    <div class="input-box-productid">						
					<label class="required" for="login-email">Product ID<span>: *</span></label><input type="text" value="" name="login[username]" id="login-email-guest" class="input-text-register required-entry validate-email">
				    </div></br>
				 </li>
            </ul>

			<input type="submit"></form>';
			*/
							
		
	}

	public function savePaymentAction(){
		
		parent::savePaymentAction();
	}

		
	
}

