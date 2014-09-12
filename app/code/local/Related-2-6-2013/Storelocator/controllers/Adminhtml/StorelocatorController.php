<?php

class Addons_Storelocator_Adminhtml_StorelocatorController extends Mage_Adminhtml_Controller_Action {
	
  protected function _initAction()
  {
    
	$this->loadLayout()->_setActiveMenu("storelocator/storelocator")->_addBreadcrumb(Mage::helper("adminhtml")->__("Store Manager"),Mage::helper("adminhtml")->__("Store Manager"));
    return $this;
  }
  public function indexAction() 
  {
    	
		$this->_initAction();
    	$this->renderLayout();
  }
  public function editAction()
  {
    $brandsId = $this->getRequest()->getParam("id");
    $brandsModel = Mage::getModel("storelocator/storelocator")->load($brandsId);
    if ($brandsModel->getId() || $brandsId == 0) {
     Mage::register("storelocator_data", $brandsModel);
     $this->loadLayout();
     $this->_setActiveMenu("storelocator/storelocator");
     $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Store Manager"), Mage::helper("adminhtml")->__("Store Manager"));
     $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Store Description"), Mage::helper("adminhtml")->__("Store Description"));
     $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
     $this->_addContent($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit"))->_addLeft($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit_tabs"));
     $this->renderLayout();
    } 
    else {
     Mage::getSingleton("adminhtml/session")->addError(Mage::helper("storelocator")->__("Item does not exist."));
     $this->_redirect("*/*/");
    }
  }

  public function newAction()
  {
		
		  $id   = $this->getRequest()->getParam("id");
		  $model  = Mage::getModel("storelocator/storelocator")->load($id);
		
		  $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		  if (!empty($data)) {
		   $model->setData($data);
		  }
		
		  Mage::register("storelocator_data", $model);
		
		  $this->loadLayout();
		  $this->_setActiveMenu("storelocator/storelocator");
		
		  $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
		
		  $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Store Manager"), Mage::helper("adminhtml")->__("Store Manager"));
		  $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Store Description"), Mage::helper("adminhtml")->__("Store Description"));
		  $this->_addContent($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit"))->_addLeft($this->getLayout()->createBlock("storelocator/adminhtml_storelocator_edit_tabs"));
		  $this->renderLayout();
         // $this->_forward("edit");
  }
  
  
		public function massDeleteAction()
		{
			$taxIds = $this->getRequest()->getParam('id');      // $this->getMassactionBlock()->setFormFieldName('tax_id'); from Mage_Adminhtml_Block_Tax_Rate_Grid
			if(!is_array($taxIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tax')->__('Please select location(s).'));
			} else {
			try {
			$rateModel = Mage::getModel('storelocator/storelocator');
			foreach ($taxIds as $taxId) {
				$rateModel->load($taxId)->delete();
			}
			Mage::getSingleton('adminhtml/session')->addSuccess(
			Mage::helper('tax')->__(
			'Total of %d record(s) were deleted.', count($taxIds)
			)
			);
			} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			}
			 
			$this->_redirect('*/*/index');
		}
  
  
  
  
  
  public function saveAction()
  {
   $post_data=$this->getRequest()->getPost();
	//var_dump($post_data);exit;
    if ($post_data) {
     try {
      $brandsModel = Mage::getModel("storelocator/storelocator")
      ->addData($post_data)
      ->setId($this->getRequest()->getParam("id"))
      ->save();
      	
      Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Store Information was successfully saved"));
      Mage::getSingleton("adminhtml/session")->setCustomdiscountData(false);

      if ($this->getRequest()->getParam("back")) {
       $this->_redirect("*/*/edit", array("id" => $brandsModel->getId()));
       return;
      }
      $this->_redirect("*/*/");
      return;
     } 
     catch (Exception $e) {
      Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
      Mage::getSingleton("adminhtml/session")->setCustomdiscountData($this->getRequest()->getPost());
      $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
     return;
     }

    }
    $this->_redirect("*/*/");
  }

	

  public function deleteAction()
  {
    if( $this->getRequest()->getParam("id") > 0 ) {
     try {
      $brandsModel = Mage::getModel("storelocator/storelocator");
      $brandsModel->setId($this->getRequest()->getParam("id"))->delete();
      Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
      $this->_redirect("*/*/");
     } 
     catch (Exception $e) {
      Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
      $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
     }
    }
    $this->_redirect("*/*/");
  }
}