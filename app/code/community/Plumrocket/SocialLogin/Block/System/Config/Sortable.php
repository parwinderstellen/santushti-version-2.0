<?php
/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket_SocialLogin
 * @copyright   Copyright (c) 2014 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */


class Plumrocket_SocialLogin_Block_System_Config_Sortable extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected $_buttons = null;
    protected $_buttonsPrepared = null;

    public function _construct() {
        parent::_construct();
        $this->setTemplate('pslogin/system/config/sortable.phtml');
        return $this;
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        // $this->assign('element', $element);
        $this->element = $element;
        return $this->toHtml();
    }

    public function getButtons()
    {
        if (is_null($this->_buttons)) {
            $types = Mage::helper('pslogin')->getTypes();
            
            $this->_buttons = array();
            foreach ($types as $type) {
                $type = Mage::getSingleton("pslogin/$type");
                if($type->enabled()) {
                    $button = $type->getButton();
                    $this->_buttons[ $button['type'] ] = $button;
                }
            }
        }
        return $this->_buttons;
    }

    public function getPreparedButtons($part)
    {
        if(is_null($this->_buttonsPrepared)) {
            $this->_buttonsPrepared = array(
                'visible' => array(),
                'hidden' => array()
            );
            $buttons = $this->getButtons();

            $storeName = $this->getRequest()->getParam('store');
            $sortableString = Mage::getStoreConfig('pslogin/general/sortable', $storeName);
            $sortable = null;
            parse_str($sortableString, $sortable);

            if(is_array($sortable)) {
                foreach ($sortable as $partName => $partButtons) {
                    foreach ($partButtons as $button) {
                        if(isset($buttons[$button])) {
                            $this->_buttonsPrepared[$partName][] = $buttons[$button];
                            unset($buttons[$button]);
                        }
                    }
                }

                // If has not sortabled enabled buttons.
                if(!empty($buttons)) {
                    if(empty($this->_buttonsPrepared['visible'])) {
                        $this->_buttonsPrepared['visible'] = array();
                    }
                    $this->_buttonsPrepared['visible'] = array_merge($this->_buttonsPrepared['visible'], $buttons);
                }

                // If visible list is empty.
                if(empty($this->_buttonsPrepared['visible'])) {
                    $this->_buttonsPrepared['visible'] = $this->_buttonsPrepared['hidden'];
                    $this->_buttonsPrepared['hidden'] = array();
                }


            }
        }

        return isset($this->_buttonsPrepared[$part])? $this->_buttonsPrepared[$part] : array();
    }

}