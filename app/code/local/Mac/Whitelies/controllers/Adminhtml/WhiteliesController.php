<?php

class Mac_Whitelies_Adminhtml_WhiteliesController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("whitelies/whitelies")->_addBreadcrumb(Mage::helper("adminhtml")->__("Whitelies  Manager"),Mage::helper("adminhtml")->__("Whitelies Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Whitelies"));
			    $this->_title($this->__("Manager Whitelies"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Whitelies"));
				$this->_title($this->__("Whitelies"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("whitelies/whitelies")->load($id);
				if ($model->getId()) {
					Mage::register("whitelies_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("whitelies/whitelies");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Whitelies Manager"), Mage::helper("adminhtml")->__("Whitelies Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Whitelies Description"), Mage::helper("adminhtml")->__("Whitelies Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("whitelies/adminhtml_whitelies_edit"))->_addLeft($this->getLayout()->createBlock("whitelies/adminhtml_whitelies_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("whitelies")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Whitelies"));
		$this->_title($this->__("Whitelies"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("whitelies/whitelies")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("whitelies_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("whitelies/whitelies");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Whitelies Manager"), Mage::helper("adminhtml")->__("Whitelies Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Whitelies Description"), Mage::helper("adminhtml")->__("Whitelies Description"));


		$this->_addContent($this->getLayout()->createBlock("whitelies/adminhtml_whitelies_edit"))->_addLeft($this->getLayout()->createBlock("whitelies/adminhtml_whitelies_edit_tabs"));

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
				$model = Mage::getModel("whitelies/whitelies")->load($this->getRequest()->getParam("id"));
				if($model->getData('smallimage')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('smallimage'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'whitelies' . DS .'whitelies'.DS;
						$uploader = new Varien_File_Uploader('smallimage');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['smallimage']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['smallimage']='whitelies/whitelies/'.$filename;
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

if((bool)$post_data['thumbnail']['delete']==1) {

	        $post_data['thumbnail']='';

}
else {

	unset($post_data['thumbnail']);

	if (isset($_FILES)){

		if ($_FILES['thumbnail']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("whitelies/whitelies")->load($this->getRequest()->getParam("id"));
				if($model->getData('thumbnail')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('thumbnail'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'whitelies' . DS .'whitelies'.DS;
						$uploader = new Varien_File_Uploader('thumbnail');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['thumbnail']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['thumbnail']='whitelies/whitelies/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("whitelies/whitelies")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Whitelies was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setWhiteliesData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setWhiteliesData($this->getRequest()->getPost());
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
						$model = Mage::getModel("whitelies/whitelies");
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
                      $model = Mage::getModel("whitelies/whitelies");
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
			$fileName   = 'whitelies.csv';
			$grid       = $this->getLayout()->createBlock('whitelies/adminhtml_whitelies_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'whitelies.xml';
			$grid       = $this->getLayout()->createBlock('whitelies/adminhtml_whitelies_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
