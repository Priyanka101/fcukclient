<?php

class Fcuk_Pressreleases_Adminhtml_PressreleasesController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("pressreleases/pressreleases")->_addBreadcrumb(Mage::helper("adminhtml")->__("Pressreleases  Manager"),Mage::helper("adminhtml")->__("Pressreleases Manager"));
				
				if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
					 $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
				}
					
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Pressreleases"));
			    $this->_title($this->__("Manager Pressreleases"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Pressreleases"));
				$this->_title($this->__("Pressreleases"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("pressreleases/pressreleases")->load($id);
				if ($model->getId()) {
					Mage::register("pressreleases_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("pressreleases/pressreleases");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Pressreleases Manager"), Mage::helper("adminhtml")->__("Pressreleases Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Pressreleases Description"), Mage::helper("adminhtml")->__("Pressreleases Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("pressreleases/adminhtml_pressreleases_edit"))->_addLeft($this->getLayout()->createBlock("pressreleases/adminhtml_pressreleases_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("pressreleases")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Pressreleases"));
		$this->_title($this->__("Pressreleases"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("pressreleases/pressreleases")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("pressreleases_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("pressreleases/pressreleases");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Pressreleases Manager"), Mage::helper("adminhtml")->__("Pressreleases Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Pressreleases Description"), Mage::helper("adminhtml")->__("Pressreleases Description"));


		$this->_addContent($this->getLayout()->createBlock("pressreleases/adminhtml_pressreleases_edit"))->_addLeft($this->getLayout()->createBlock("pressreleases/adminhtml_pressreleases_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						
				 //save image
		try{

if((bool)$post_data['banner']['delete']==1) {

	        $post_data['banner']='';

}
else {

	unset($post_data['banner']);

	if (isset($_FILES)){

		if ($_FILES['banner']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("pressreleases/pressreleases")->load($this->getRequest()->getParam("id"));
				if($model->getData('banner')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('banner'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'pressreleases' . DS .'pressreleases'.DS;
						$uploader = new Varien_File_Uploader('banner');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['banner']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['banner']='pressreleases/pressreleases/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("pressreleases/pressreleases")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Pressreleases was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPressreleasesData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setPressreleasesData($this->getRequest()->getPost());
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
						$model = Mage::getModel("pressreleases/pressreleases");
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
				$ids = $this->getRequest()->getPost('release_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("pressreleases/pressreleases");
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
			$fileName   = 'pressreleases.csv';
			$grid       = $this->getLayout()->createBlock('pressreleases/adminhtml_pressreleases_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'pressreleases.xml';
			$grid       = $this->getLayout()->createBlock('pressreleases/adminhtml_pressreleases_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
