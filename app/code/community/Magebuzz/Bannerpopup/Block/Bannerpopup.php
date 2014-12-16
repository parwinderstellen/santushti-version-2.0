<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Bannerpopup extends Mage_Core_Block_Template
{
  public function _prepareLayout()
  {
    return parent::_prepareLayout();
  }

  public function getListBannerpopup()     
  { 
    $bannerModel =$this->_model()->getCollection()->AddFieldToFilter('status',1);
    foreach($bannerModel as $banner)
    {
      $imageBanner[] = array('id'=>$banner->getBannerpopupId(),'name'=>$banner->getFilename(),'title'=>$banner->getTitle(),'link'=>$banner->getLink());					
    }
    return $imageBanner;

  }
  protected function _helper(){
    return Mage::helper('bannerpopup');
  }
  protected function _model(){
    return Mage::getModel('bannerpopup/bannerpopup');
  }
}