<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Model_Bannerpopup extends Mage_Core_Model_Abstract
{
  public function _construct()
  {
    parent::_construct();
    $this->_init('bannerpopup/bannerpopup');
  }
  public function addShowImage($image_id){    
    $bannerModel = $this->load($image_id);
    $countShow = $bannerModel->getShowcounts();
    $this->setBannerpopupId($image_id)->setShowcounts($countShow+1);
    $this->save();    
    return true;
  }
}