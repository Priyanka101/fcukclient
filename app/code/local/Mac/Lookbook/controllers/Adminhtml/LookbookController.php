<?php

class Mac_Lookbook_Adminhtml_LookbookController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("lookbook/lookbook")->_addBreadcrumb(Mage::helper("adminhtml")->__("Lookbook  Manager"),Mage::helper("adminhtml")->__("Lookbook Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Lookbook"));
			    $this->_title($this->__("Manager Lookbook"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Lookbook"));
				$this->_title($this->__("Lookbook"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("lookbook/lookbook")->load($id);
				if ($model->getId()) {
					Mage::register("lookbook_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("lookbook/lookbook");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Lookbook Manager"), Mage::helper("adminhtml")->__("Lookbook Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Lookbook Description"), Mage::helper("adminhtml")->__("Lookbook Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("lookbook/adminhtml_lookbook_edit"))->_addLeft($this->getLayout()->createBlock("lookbook/adminhtml_lookbook_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("lookbook")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Lookbook"));
		$this->_title($this->__("Lookbook"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("lookbook/lookbook")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("lookbook_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("lookbook/lookbook");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Lookbook Manager"), Mage::helper("adminhtml")->__("Lookbook Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Lookbook Description"), Mage::helper("adminhtml")->__("Lookbook Description"));


		$this->_addContent($this->getLayout()->createBlock("lookbook/adminhtml_lookbook_edit"))->_addLeft($this->getLayout()->createBlock("lookbook/adminhtml_lookbook_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						
				 //save image
		try{

if((bool)$post_data['smallimage']['delete']==1) {

	        $post_data['smallimage']='';

}
else {

	unset($post_data['smallimage']);

	if (isset($_FILES)){

		if ($_FILES['smallimage']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("lookbook/lookbook")->load($this->getRequest()->getParam("id"));
				if($model->getData('smallimage')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('smallimage'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'lookbook' . DS .'lookbook'.DS;
						$uploader = new Varien_File_Uploader('smallimage');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['smallimage']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['smallimage']='lookbook/lookbook/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image

				 //save image
		try{

if((bool)$post_data['thumbnailimage']['delete']==1) {

	        $post_data['thumbnailimage']='';

}
else {

	unset($post_data['thumbnailimage']);

	if (isset($_FILES)){

		if ($_FILES['thumbnailimage']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("lookbook/lookbook")->load($this->getRequest()->getParam("id"));
				if($model->getData('thumbnailimage')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('thumbnailimage'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'lookbook' . DS .'lookbook'.DS;
						$uploader = new Varien_File_Uploader('thumbnailimage');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['thumbnailimage']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['thumbnailimage']='lookbook/lookbook/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("lookbook/lookbook")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Lookbook was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setLookbookData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setLookbookData($this->getRequest()->getPost());
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
						$model = Mage::getModel("lookbook/lookbook");
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
                      $model = Mage::getModel("lookbook/lookbook");
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
			$fileName   = 'lookbook.csv';
			$grid       = $this->getLayout()->createBlock('lookbook/adminhtml_lookbook_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'lookbook.xml';
			$grid       = $this->getLayout()->createBlock('lookbook/adminhtml_lookbook_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
