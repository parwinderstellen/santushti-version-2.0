<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Helper_Data extends Mage_Core_Helper_Abstract
{

  public function getConfigShowPopup(){
    return Mage::getStoreConfig('bannerpopup/general/showpopup');
  }
  public function getConfigHidePopup(){
    return Mage::getStoreConfig('bannerpopup/general/hidepopup');
  }
  public function getConfigCookieTime(){
    return Mage::getStoreConfig('bannerpopup/general/cookietime');
  }
  
}