<?php

class Fcuk_Check_Adminhtml_NoncodController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("check/noncod")->_addBreadcrumb(Mage::helper("adminhtml")->__("Noncod  Manager"),Mage::helper("adminhtml")->__("Noncod Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Check"));
			    $this->_title($this->__("Manager Noncod"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Check"));
				$this->_title($this->__("Noncod"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("check/noncod")->load($id);
				if ($model->getId()) {
					Mage::register("noncod_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("check/noncod");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Noncod Manager"), Mage::helper("adminhtml")->__("Noncod Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Noncod Description"), Mage::helper("adminhtml")->__("Noncod Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("check/adminhtml_noncod_edit"))->_addLeft($this->getLayout()->createBlock("check/adminhtml_noncod_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("check")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Check"));
		$this->_title($this->__("Noncod"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("check/noncod")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("noncod_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("check/noncod");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Noncod Manager"), Mage::helper("adminhtml")->__("Noncod Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Noncod Description"), Mage::helper("adminhtml")->__("Noncod Description"));


		$this->_addContent($this->getLayout()->createBlock("check/adminhtml_noncod_edit"))->_addLeft($this->getLayout()->createBlock("check/adminhtml_noncod_edit_tabs"));

		$this->renderLayout();

		}


		public function saveAction()
		{
				
				//if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				$post_data=$this->getRequest()->getPost();
		//	print_r($post_data);
		//	exit;
		
			//	echo $pincode;
			//	print_r($post_data);
			//	echo $pincod['pincode'];
			//	exit;
				if ($post_data) {
					if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
					
					try {	
				
				/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					// Only *.csv extention would work
	           		$uploader->setAllowedExtensions(array('csv'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ."noncod" .DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					$csv = new Varien_File_Csv();
					$dataCollection = $csv->getData($path.$_FILES['filename']['name']); //path to csv
					array_shift($dataCollection);
					//echo "<pre>";
				//	print_r($dataCollection);
					
					
				} catch (Exception $e) {
		      
		        }
					//echo $_FILES['filename']['name'];
					//$helperdata = Mage::helper("check");
				 	$model_product = Mage::getModel("check/noncod");
					foreach($dataCollection as $_data){
					
									
							//$helperdata->_updateStocks($_data);
													
						//	$helperdata->_addDataProduct($_data);
						
							$new_data['pincode'] = $_data[0];
							$new_data['city'] = $_data[1];
							$new_data['location'] = $_data[2];
							$new_data['state'] = $_data[3];
							$new_data['cod'] = $_data[4];
							$new_data['zone'] = $_data[5];
							$new_data['eastzone'] =$_data[6];
							
							$model_product->setData($new_data);
							$model_product->save();
						} 
					
					
					Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Noncod was successfully saved"));
					$this->_redirect("*/*/");
						return;	
				
					}
					/* $pincode=$this->getRequest()->getParam('pincode');
					if($post_data=$this->getRequest()->getPost())
					{
					
										
					} */
					
									
					
					try {

						$model = Mage::getModel("check/noncod")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Noncod was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setCodData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setCodData($this->getRequest()->getPost());
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
						$model = Mage::getModel("check/noncod");
						$model->setId($this->getRequest()->getParam("id"))->delete();
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

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ncod_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("check/noncod");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'noncod.csv';
			$grid       = $this->getLayout()->createBlock('check/adminhtml_noncod_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'noncod.xml';
			$grid       = $this->getLayout()->createBlock('check/adminhtml_noncod_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
