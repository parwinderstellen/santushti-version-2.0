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


class Plumrocket_SocialLogin_Block_Buttons extends Mage_Core_Block_Template
{
    protected $_buttons = null;
    protected $_buttonsPrepared = null;
    protected $_loaderImg = 'loader.gif';

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

    public function getPreparedButtons($part = null)
    {
        if(is_null($this->_buttonsPrepared)) {
            $this->_buttonsPrepared = array(
                'visible' => array(),
                'hidden' => array()
            );
            $buttons = $this->getButtons();

            $sortableString = Mage::getStoreConfig('pslogin/general/sortable');
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

                // Set visible.
                foreach($this->_buttonsPrepared['visible'] as &$btn) {
                    $btn['visible'] = true;
                }
            }
        }

        return isset($this->_buttonsPrepared[$part]) ?
                $this->_buttonsPrepared[$part] :
                array_merge($this->_buttonsPrepared['visible'], $this->_buttonsPrepared['hidden']);
    }

    public function hasButtons()
    {
        return (bool)$this->getPreparedButtons();
    }

    public function showLoginFullButtons()
    {
        $visible = $this->getPreparedButtons('visible');
        return count($visible) <= 6;
    }

    public function showRegisterFullButtons()
    {
        $all = $this->getPreparedButtons();
        return count($all) <= 6;
    }

    public function enableForLogin()
    {
        return Mage::helper('pslogin')->moduleEnabled() && Mage::helper('pslogin')->forLoginEnabled();
    }

    public function enableForRegister()
    {
        return Mage::helper('pslogin')->moduleEnabled() && Mage::helper('pslogin')->forRegisterEnabled();
    }

    public function getLoaderUrl()
    {
        return Mage::getDesign()->getSkinUrl('images/plumrocket/pslogin/'. $this->_loaderImg);
    }
}