<?php

class Mac_Custom_Adminhtml_KittedoutController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("custom/kittedout")->_addBreadcrumb(Mage::helper("adminhtml")->__("Kittedout  Manager"),Mage::helper("adminhtml")->__("Kittedout Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Custom"));
			    $this->_title($this->__("Manager Kittedout"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Custom"));
				$this->_title($this->__("Kittedout"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("custom/kittedout")->load($id);
				if ($model->getId()) {
					Mage::register("kittedout_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("custom/kittedout");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Kittedout Manager"), Mage::helper("adminhtml")->__("Kittedout Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Kittedout Description"), Mage::helper("adminhtml")->__("Kittedout Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("custom/adminhtml_kittedout_edit"))->_addLeft($this->getLayout()->createBlock("custom/adminhtml_kittedout_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("custom")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Custom"));
		$this->_title($this->__("Kittedout"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("custom/kittedout")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("kittedout_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("custom/kittedout");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Kittedout Manager"), Mage::helper("adminhtml")->__("Kittedout Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Kittedout Description"), Mage::helper("adminhtml")->__("Kittedout Description"));


		$this->_addContent($this->getLayout()->createBlock("custom/adminhtml_kittedout_edit"))->_addLeft($this->getLayout()->createBlock("custom/adminhtml_kittedout_edit_tabs"));

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
				$model = Mage::getModel("custom/kittedout")->load($this->getRequest()->getParam("id"));
				if($model->getData('smallimage')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('smallimage'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'custom' . DS .'kittedout'.DS;
						$uploader = new Varien_File_Uploader('smallimage');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['smallimage']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['smallimage']='custom/kittedout/'.$filename;
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
				$model = Mage::getModel("custom/kittedout")->load($this->getRequest()->getParam("id"));
				if($model->getData('thumbnail')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('thumbnail'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'custom' . DS .'kittedout'.DS;
						$uploader = new Varien_File_Uploader('thumbnail');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['thumbnail']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['thumbnail']='custom/kittedout/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("custom/kittedout")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Kittedout was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setKittedoutData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setKittedoutData($this->getRequest()->getPost());
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
						$model = Mage::getModel("custom/kittedout");
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
                      $model = Mage::getModel("custom/kittedout");
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
			$fileName   = 'kittedout.csv';
			$grid       = $this->getLayout()->createBlock('custom/adminhtml_kittedout_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'kittedout.xml';
			$grid       = $this->getLayout()->createBlock('custom/adminhtml_kittedout_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
