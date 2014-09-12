<?php

class Fcuk_Pressreleases_Adminhtml_PresscoverageController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("pressreleases/presscoverage")->_addBreadcrumb(Mage::helper("adminhtml")->__("Presscoverage  Manager"),Mage::helper("adminhtml")->__("Presscoverage Manager"));
				
				if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
					 $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
					}
				return $this;
				
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Pressreleases"));
			    $this->_title($this->__("Manager Presscoverage"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Pressreleases"));
				$this->_title($this->__("Presscoverage"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("pressreleases/presscoverage")->load($id);
				if ($model->getId()) {
					Mage::register("presscoverage_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("pressreleases/presscoverage");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Presscoverage Manager"), Mage::helper("adminhtml")->__("Presscoverage Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Presscoverage Description"), Mage::helper("adminhtml")->__("Presscoverage Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("pressreleases/adminhtml_presscoverage_edit"))->_addLeft($this->getLayout()->createBlock("pressreleases/adminhtml_presscoverage_edit_tabs"));
					$this->_addContent($this->getLayout()->createBlock('adminhtml/media_uploader'));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("pressreleases")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}
		
		public function uploadAction()
		{
			try {
				$uploader = new Varien_File_Uploader('file');
				$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
				$uploader->setAllowRenameFiles(false);
				$uploader->setFilesDispersion(false);

				$path = Mage::getBaseDir('media') .'/pressreleases/presscoverage/';
				//echo $path;exit;
				
				$uploader->save($path);
				
			} catch (Exception $e) {
				$result = array('error'=>$e->getMessage(), 'errorcode'=>$e->getCode());
			}

			$this->getResponse()->setBody(Zend_Json::encode($result));
		}

		public function newAction()
		{

		$this->_title($this->__("Pressreleases"));
		$this->_title($this->__("Presscoverage"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("pressreleases/presscoverage")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("presscoverage_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("pressreleases/presscoverage");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Presscoverage Manager"), Mage::helper("adminhtml")->__("Presscoverage Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Presscoverage Description"), Mage::helper("adminhtml")->__("Presscoverage Description"));


		$this->_addContent($this->getLayout()->createBlock("pressreleases/adminhtml_presscoverage_edit"))->_addLeft($this->getLayout()->createBlock("pressreleases/adminhtml_presscoverage_edit_tabs"));
		$this->_addContent($this->getLayout()->createBlock('adminhtml/media_uploader'));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();
			//var_dump($post_data);exit;

				if ($post_data) {

					try {

						
				 //save image
		
//save image


						$model = Mage::getModel("pressreleases/presscoverage")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Presscoverage was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPresscoverageData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setPresscoverageData($this->getRequest()->getPost());
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
						$model = Mage::getModel("pressreleases/presscoverage");
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
				$ids = $this->getRequest()->getPost('coverage_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("pressreleases/presscoverage");
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
			$fileName   = 'presscoverage.csv';
			$grid       = $this->getLayout()->createBlock('pressreleases/adminhtml_presscoverage_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'presscoverage.xml';
			$grid       = $this->getLayout()->createBlock('pressreleases/adminhtml_presscoverage_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
