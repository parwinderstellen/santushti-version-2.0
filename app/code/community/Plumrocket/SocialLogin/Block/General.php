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


class Plumrocket_SocialLogin_Block_General extends Mage_Core_Block_Template
{
	protected function _toHtml()
    {
        // Set referer.
        if(!$customerId = Mage::getSingleton('customer/session')->getCustomerId()) {
            $moduleName = $this->getRequest()->getModuleName();
            $skipModules = Mage::helper('pslogin')->getRefererLinkSkipModules();
            if( ($moduleName != 'cms' && $this->getRequest()->getActionName() != 'noRoute') && !in_array($moduleName, $skipModules)) {
                $referer = $this->helper('core/url')->getCurrentBase64Url();
                Mage::helper('pslogin')->refererLink($referer);
            }
        }
        
        return parent::_toHtml();
    }
}