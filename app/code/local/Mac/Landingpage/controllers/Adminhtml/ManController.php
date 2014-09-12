<?php

class Mac_Landingpage_Adminhtml_ManController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("landingpage/man")->_addBreadcrumb(Mage::helper("adminhtml")->__("Man  Manager"),Mage::helper("adminhtml")->__("Man Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Landingpage"));
			    $this->_title($this->__("Manager Man"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Landingpage"));
				$this->_title($this->__("Man"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("landingpage/man")->load($id);
				if ($model->getId()) {
					Mage::register("man_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("landingpage/man");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Man Manager"), Mage::helper("adminhtml")->__("Man Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Man Description"), Mage::helper("adminhtml")->__("Man Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("landingpage/adminhtml_man_edit"))->_addLeft($this->getLayout()->createBlock("landingpage/adminhtml_man_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("landingpage")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Landingpage"));
		$this->_title($this->__("Man"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("landingpage/man")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("man_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("landingpage/man");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Man Manager"), Mage::helper("adminhtml")->__("Man Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Man Description"), Mage::helper("adminhtml")->__("Man Description"));


		$this->_addContent($this->getLayout()->createBlock("landingpage/adminhtml_man_edit"))->_addLeft($this->getLayout()->createBlock("landingpage/adminhtml_man_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();
/* print_r($post_data);exit; */

				if ($post_data) {

					try {

						
				 //save image
		try{

if((bool)$post_data['image']['delete']==1) {

	        $post_data['image']='';

}
else {

	unset($post_data['image']);

	if (isset($_FILES)){

		if ($_FILES['image']['name']) {
	

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("landingpage/man")->load($this->getRequest()->getParam("id"));
				if($model->getData('image')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('image'))));	
				}
			}
			
						$path = Mage::getBaseDir('media') . DS . 'landingpage' . DS .'man'.DS;
						//	print_r($_FILES);exit;
						$uploader = new Varien_File_Uploader('image');
						$uploader->setAllowedExtensions(array('jpg','png','gif','mp4'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['image']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['image']='landingpage/man/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("landingpage/man")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Man was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setManData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setManData($this->getRequest()->getPost());
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
						$model = Mage::getModel("landingpage/man");
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
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("landingpage/man");
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
			$fileName   = 'man.csv';
			$grid       = $this->getLayout()->createBlock('landingpage/adminhtml_man_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'man.xml';
			$grid       = $this->getLayout()->createBlock('landingpage/adminhtml_man_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
