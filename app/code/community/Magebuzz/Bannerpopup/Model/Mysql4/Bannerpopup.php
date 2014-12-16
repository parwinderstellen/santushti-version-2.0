<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Model_Mysql4_Bannerpopup extends Mage_Core_Model_Mysql4_Abstract
{
  public function _construct()
  {    
    $this->_init('bannerpopup/bannerpopup', 'bannerpopup_id');
  }
}