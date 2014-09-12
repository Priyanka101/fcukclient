<?php

class Fcuk_Shiptrack_Adminhtml_ShipmentController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("shiptrack/shipment")->_addBreadcrumb(Mage::helper("adminhtml")->__("Shipment  Manager"),Mage::helper("adminhtml")->__("Shipment Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Shiptrack"));
			    $this->_title($this->__("Manager Shipment"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Shiptrack"));
				$this->_title($this->__("Shipment"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("shiptrack/shipment")->load($id);
				if ($model->getId()) {
					Mage::register("shipment_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("shiptrack/shipment");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Shipment Manager"), Mage::helper("adminhtml")->__("Shipment Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Shipment Description"), Mage::helper("adminhtml")->__("Shipment Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("shiptrack/adminhtml_shipment_edit"))->_addLeft($this->getLayout()->createBlock("shiptrack/adminhtml_shipment_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("shiptrack")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Shiptrack"));
		$this->_title($this->__("Shipment"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("shiptrack/shipment")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("shipment_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("shiptrack/shipment");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Shipment Manager"), Mage::helper("adminhtml")->__("Shipment Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Shipment Description"), Mage::helper("adminhtml")->__("Shipment Description"));


		$this->_addContent($this->getLayout()->createBlock("shiptrack/adminhtml_shipment_edit"))->_addLeft($this->getLayout()->createBlock("shiptrack/adminhtml_shipment_edit_tabs"));

		$this->renderLayout();

		}
		
	public function saveAction()
		{
				
				//if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				$post_data=$this->getRequest()->getPost();
			

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
					$path = Mage::getBaseDir('media') . DS ."tracking" .DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					$csv = new Varien_File_Csv();
					$dataCollection = $csv->getData($path.$_FILES['filename']['name']); //path to csv
					array_shift($dataCollection);
				//echo "<pre>";
				//print_r($dataCollection);
			
					
					
				} catch (Exception $e) {
		      
		        }
					//echo $_FILES['filename']['name'];
					//$helperdata = Mage::helper("check");
				 	$model_shipment = Mage::getModel("shiptrack/shipment");
					foreach($dataCollection as $_data){
					
									
							//$helperdata->_updateStocks($_data);
													
						//	$helperdata->_addDataProduct($_data);
						
						$new_data['awbnumber'] = $_data[0];
						$new_data['carrier'] = $_data[1];
						$new_data['status'] = $_data[2];
						//	$new_data['state'] = $_data[3];
						$new_data['cod'] = $_data[3];
						$new_data['ncod'] = $_data[4];
						//	$new_data['eastzone'] =$_data[6];
								
					//	echo "i m here";
							
							$model_shipment->setData($new_data);
												
							$model_shipment->save();
								
						} 
				
					
					Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Shipment was successfully saved"));
					$this->_redirect("*/*/");
						return;	
				
					}
										
					try {

						$model = Mage::getModel("shiptrack/shipment")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Shipment was successfully saved"));
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
						$model = Mage::getModel("shiptrack/shipment");
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
				$ids = $this->getRequest()->getPost('s_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("shiptrack/shipment");
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
			$fileName   = 'shipment.csv';
			$grid       = $this->getLayout()->createBlock('shiptrack/adminhtml_shipment_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'shipment.xml';
			$grid       = $this->getLayout()->createBlock('shiptrack/adminhtml_shipment_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
