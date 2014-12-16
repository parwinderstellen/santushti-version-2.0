<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Adminhtml_BannerpopupController extends Mage_Adminhtml_Controller_action
{

  protected function _initAction() {
    $this->loadLayout()
    ->_setActiveMenu('bannerpopup/items')
    ->_addBreadcrumb(Mage::helper('adminhtml')->__('Images Manager'), Mage::helper('adminhtml')->__('Images Manager'));
    return $this;
  }   

  public function indexAction() {
    $this->_initAction()
    ->renderLayout();
  }

  public function editAction() {
    $id     = $this->getRequest()->getParam('id');
    $model  = Mage::getModel('bannerpopup/bannerpopup')->load($id);

    if ($model->getId() || $id == 0) {
      $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
      if (!empty($data)) {
        $model->setData($data);
      }

      Mage::register('bannerpopup_data', $model);

      $this->loadLayout();
      $this->_setActiveMenu('bannerpopup/items');

      $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
      $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);

      $this->_addContent($this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_edit'))
      ->_addLeft($this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_edit_tabs'));

      $this->renderLayout();
    } else {
      Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bannerpopup')->__('Image does not exist'));
      $this->_redirect('*/*/');
    }
  }

  public function newAction() {
    $this->_forward('edit');
  }

  public function gridAction()
  {
    $this->loadLayout();
    $this->getResponse()->setBody($this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_grid')->toHtml());
  }

  public function saveAction() {
    if ($data = $this->getRequest()->getPost()) {

      if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
        try {	
          $uploader = new Varien_File_Uploader('filename');
          $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
          $uploader->setAllowRenameFiles(false);
          $uploader->setFilesDispersion(false);
          $path = Mage::getBaseDir('media') . DS.'bannerpopup'.DS ;
          $uploader->save($path, $_FILES['filename']['name'] );
        } catch (Exception $e) {
        }
        $data['filename'] = $_FILES['filename']['name'];
      }
      $model = Mage::getModel('bannerpopup/bannerpopup');		
      $model->setData($data)
      ->setId($this->getRequest()->getParam('id'));
      try {
        if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
          $model->setCreatedTime(now())
          ->setUpdateTime(now());
        } else {
          $model->setUpdateTime(now());
        }	
        $model->save();
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bannerpopup')->__('Image was successfully saved'));
        Mage::getSingleton('adminhtml/session')->setFormData(false);
        if ($this->getRequest()->getParam('back')) {
          $this->_redirect('*/*/edit', array('id' => $model->getId()));
          return;
        }
        $this->_redirect('*/*/');
        return;
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        Mage::getSingleton('adminhtml/session')->setFormData($data);
        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
        return;
      }
    }
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bannerpopup')->__('Unable to find item to save'));
    $this->_redirect('*/*/');
  }

  public function deleteAction() {
    if( $this->getRequest()->getParam('id') > 0 ) {
      try {
        $model = Mage::getModel('bannerpopup/bannerpopup');
        $model->setId($this->getRequest()->getParam('id'))
        ->delete();
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Image was successfully deleted'));
        $this->_redirect('*/*/');
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
      }
    }
    $this->_redirect('*/*/');
  }

  public function massDeleteAction() {
    $bannerpopupIds = $this->getRequest()->getParam('bannerpopup');
    if(!is_array($bannerpopupIds)) {
      Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    } else {
      try {
        foreach ($bannerpopupIds as $bannerpopupId) {
          $bannerpopup = Mage::getModel('bannerpopup/bannerpopup')->load($bannerpopupId);
          $bannerpopup->delete();
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(
        Mage::helper('adminhtml')->__(
        'Total of %d record(s) were successfully deleted', count($bannerpopupIds)
        )
        );
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
      }
    }
    $this->_redirect('*/*/index');
  }

  public function massStatusAction()
  {
    $bannerpopupIds = $this->getRequest()->getParam('bannerpopup');
    if(!is_array($bannerpopupIds)) {
      Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    } else {
      try {
        foreach ($bannerpopupIds as $bannerpopupId) {
          $bannerpopup = Mage::getSingleton('bannerpopup/bannerpopup')
          ->load($bannerpopupId)
          ->setStatus($this->getRequest()->getParam('status'))
          ->setIsMassupdate(true)
          ->save();
        }
        $this->_getSession()->addSuccess(
        $this->__('Total of %d record(s) were successfully updated', count($bannerpopupIds))
        );
      } catch (Exception $e) {
        $this->_getSession()->addError($e->getMessage());
      }
    }
    $this->_redirect('*/*/index');
  }

  public function exportCsvAction()
  {
    $fileName   = 'bannerpopup.csv';
    $content    = $this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_grid')
    ->getCsv();
    $this->_sendUploadResponse($fileName, $content);
  }

  public function exportXmlAction()
  {
    $fileName   = 'bannerpopup.xml';
    $content    = $this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_grid')
    ->getXml();
    $this->_sendUploadResponse($fileName, $content);
  }

  protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
  {
    $response = $this->getResponse();
    $response->setHeader('HTTP/1.1 200 OK','');
    $response->setHeader('Pragma', 'public', true);
    $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
    $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
    $response->setHeader('Last-Modified', date('r'));
    $response->setHeader('Accept-Ranges', 'bytes');
    $response->setHeader('Content-Length', strlen($content));
    $response->setHeader('Content-type', $contentType);
    $response->setBody($content);
    $response->sendResponse();
    die;
  }
}