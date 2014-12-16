<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/

class Magebuzz_Bannerpopup_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {	
		$this->loadLayout();  
		$this->renderLayout();
    }
    public function addclickAction(){          
      $imageId = $this->getRequest()->getParam('id');
      $bannerModel = Mage::getModel('bannerpopup/bannerpopup')->load($imageId);
      $countView = $bannerModel->getViewcounts();    
      $urlLink = $bannerModel->getLink();    
      $bannerModel->setViewcounts($countView+1)->setBannerpopupId($imageId);
      try{
      $bannerModel->save();
        if($urlLink ==''|| $urlLink ==null){         
           echo 'false';
        }else{
         echo $urlLink;
        }      
      }catch(Exeption $e){
      echo 'false';  
      }         
    }
}