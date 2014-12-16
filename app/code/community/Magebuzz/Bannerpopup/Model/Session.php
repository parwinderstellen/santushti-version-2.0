<?php
 /*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Model_Session extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bannerpopup');
    }
}