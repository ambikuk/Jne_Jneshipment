<?php

class Jne_Jneshipment_Adminhtml_JneshipmentController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
				->_setActiveMenu('jneshipment/items')
				->_addBreadcrumb(Mage::helper('adminhtml')->__('Jneshipment Manager'), Mage::helper('adminhtml')->__('Banner Manager'));

		return $this;
	}

	public function indexAction()
	{
		$this->_title($this->__('Jneshipment'))
				->_title($this->__('Manage Tracking AWB'));
		$this->_initAction()
				->renderLayout();
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('jneshipment/jneshipment')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('jneshipment_data', $model);
			
			$this->_title($this->__('Bannerslider'))
				->_title($this->__('Manage banner'));
			if ($model->getId()){
				$this->_title($model->getTitle());
			}else{
				$this->_title($this->__('New Banner'));
			}

			$this->loadLayout();
			$this->_setActiveMenu('jneshipment/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_edit'))
				->_addLeft($this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('jneshipment')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function xmlAction()
	{
		header('content-type: text/plain');
		$id = $this->getRequest()->getParam('id');
		$type = $this->getRequest()->getParam('type');
		$model = Mage::getModel('jneshipment/jneshipment')->load($id);
		if ($type == 'shipmentvalidation')
			echo $model->getStatusAwb();
		elseif ($type == 'return')
			echo $model->getStatusReturn();
		elseif ($type == 'pickup')
			echo $model->getStatusPickup();
		exit;
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	protected function _initItem()
	{
		if (!Mage::registry('jneshipment_categories'))
		{
			if ($this->getRequest()->getParam('id'))
			{
				Mage::register('jneshipment_categories', Mage::getModel('jneshipment/jneshipment')
								->load($this->getRequest()->getParam('id'))->getCategories());
			}
		}
	}

	public function categoriesAction()
	{
		$this->_initItem();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_edit_tab_categories')->toHtml()
		);
	}

	public function categoriesJsonAction()
	{
		$this->_initItem();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_edit_tab_categories')
						->getCategoryChildrenJson($this->getRequest()->getParam('category'))
		);
	}

	public function exportCsvAction()
	{
		$fileName = 'jneshipment.csv';
		$content = $this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_grid')
				->getCsv();

		$this->_sendUploadResponse($fileName, $content);
	}

	public function exportXmlAction()
	{
		$fileName = 'jneshipment.xml';
		$content = $this->getLayout()->createBlock('jneshipment/adminhtml_jneshipment_grid')
				->getXml();

		$this->_sendUploadResponse($fileName, $content);
	}

	protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream')
	{
		$response = $this->getResponse();
		$response->setHeader('HTTP/1.1 200 OK', '');
		$response->setHeader('Pragma', 'public', true);
		$response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
		$response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
		$response->setHeader('Last-Modified', date('r'));
		$response->setHeader('Accept-Ranges', 'bytes');
		$response->setHeader('Content-Length', strlen($content));
		$response->setHeader('Content-type', $contentType);
		$response->setBody($content);
		$response->sendResponse();
		die;
	}

	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost())
		{
			$id = $this->getRequest()->getParam('id');
			$model = Mage::getModel('jneshipment/jneshipment')->load($id);
			$model->setOrderId($data['order_id']);
			$model->setAwb($data['awb']);
			$model->save();
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bannerslider')->__('Item was successfully saved'));
		}
		$this->_redirect('*/*/');
	}
}