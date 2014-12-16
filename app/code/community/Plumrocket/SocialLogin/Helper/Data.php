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


class Plumrocket_SocialLogin_Helper_Data extends Mage_Core_Helper_Abstract
{
	const REFERER_QUERY_PARAM_NAME = 'pslogin_referer';
	const SHOW_POPUP_PARAM_NAME = 'pslogin_show_popup';
	const FAKE_EMAIL_PREFIX = 'temp-email-ps';
	const TIME_TO_EDIT = 300;
	const DEBUG_MODE = false;

	public function moduleEnabled()
	{
		return (bool)Mage::getStoreConfig('pslogin/general/enable');
	}

	public function validateIgnore()
	{
		return (bool)Mage::getStoreConfig('pslogin/general/validate_ignore');
	}

	public function getShareData()
	{
		return Mage::getStoreConfig('pslogin/share');
	}

	public function shareEnabled()
	{
		return $this->moduleEnabled() && Mage::getStoreConfig('pslogin/share/enable');
	}

	public function forLoginEnabled()
	{
		return (bool)Mage::getStoreConfig('pslogin/general/enable_for_login');
	}

	public function forRegisterEnabled()
	{
		return (bool)Mage::getStoreConfig('pslogin/general/enable_for_register');
	}

	public function photoEnabled()
	{
		return $this->moduleEnabled() && Mage::getStoreConfig('pslogin/general/enable_photo');
	}

	public function getPhotoPath($checkIsEnabled = true)
	{
		if($checkIsEnabled && !$this->photoEnabled()) {
			return false;
		}

		if(!$customerId = Mage::getSingleton('customer/session')->getCustomerId()) {
            return false;
        }

        $path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .'pslogin'. DS .'photo'. DS . $customerId .'.'. Plumrocket_SocialLogin_Model_Account::PHOTO_FILE_EXT;
        $pathUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) .'pslogin/photo/' . $customerId .'.'. Plumrocket_SocialLogin_Model_Account::PHOTO_FILE_EXT;

        if(!file_exists($path)) {
            return false;
        }

        return $pathUrl;
	}

	public function isGlobalScope()
	{
		return Mage::getSingleton('customer/customer')->getSharingConfig()->isGlobalScope();
		// return (bool)(Mage::getStoreConfig('customer/account_share/scope') == 0);
	}

	public function getRedirect()
	{
		return array(
			'login' => Mage::getStoreConfig('pslogin/general/redirect_for_login'),
			'login_link' => Mage::getStoreConfig('pslogin/general/redirect_for_login_link'),
			'register' => Mage::getStoreConfig('pslogin/general/redirect_for_register'),
			'register_link' => Mage::getStoreConfig('pslogin/general/redirect_for_register_link'),
		);
	}

	public function getTypes($onlyEnabled = true)
	{
		$groups = Mage::getStoreConfig('pslogin');
		unset(
			$groups['general'],
			$groups['share']
		);

		$types = array();
		foreach ($groups as $name => $fields) {
			if($onlyEnabled && empty($fields['enable'])) {
				continue;
			}
			$types[] = $name;
		}

		return $types;
	}

	public function refererLink($value = false)
	{
		Mage::log(base64_decode($value), null, 'pslogin_referer', true);
		// Core session.
		$session = Mage::getSingleton('core/session');
		$prevValueByCore = $session->getLoginMainRedirectUrl();

		if($value) {
			$session->setLoginMainRedirectUrl($value);
		}elseif($value === null) {
			$session->unsLoginMainRedirectUrl();
		}

		// Customer session.
		$session = Mage::getSingleton('customer/session');
		$prevValueByCustomer = $session->getData(self::REFERER_QUERY_PARAM_NAME);

		if($value) {
			$session->setData(self::REFERER_QUERY_PARAM_NAME, $value);
		}elseif($value === null) {
			$session->unsetData(self::REFERER_QUERY_PARAM_NAME);
		}

		return $prevValueByCore? $prevValueByCore : $prevValueByCustomer;
	}

	public function getRefererLinkSkipModules()
	{
		return array('customer', /*'checkout',*/ 'pslogin');
	}

	public function showPopup($flag = null)
	{
		$session = Mage::getSingleton('customer/session');
		$show = $session->getData(self::SHOW_POPUP_PARAM_NAME);

		if($flag) {
			$session->setData(self::SHOW_POPUP_PARAM_NAME, true);
		}else{
			$session->unsetData(self::SHOW_POPUP_PARAM_NAME);
		}

		return $show;
	}

	public function getRedirectUrl($after = 'login')
    {
        $redirectUrl = null;
        $redirect = $this->getRedirect();
        switch($redirect[$after]) {

            case '__referer__':
                if(!$referer = Mage::app()->getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)) {
                    $referer = $this->refererLink();
                }

                if ($referer) {
                    // Rebuild referer URL to handle the case when SID was changed
                    $referer = Mage::getSingleton('core/url')
                        ->getRebuiltUrl( Mage::helper('core')->urlDecode($referer));
                    if ($this->isUrlInternal($referer)) {
	                    $redirectUrl = $referer;
	                }
                }else{
                    $redirectUrl = Mage::helper('customer')->getDashboardUrl();
                }
                break;

            case '__custom__':
                $redirectUrl = $redirect["{$after}_link"];
                if (!$this->isUrlInternal($redirectUrl)) {
                    $redirectUrl = Mage::getBaseUrl() . $redirectUrl;
                }
                break;

            case '__dashboard__':
                $redirectUrl = Mage::helper('customer')->getDashboardUrl();
                break;

            default:
                if(is_numeric($redirect[$after])) {
                    $redirectUrl = Mage::helper('cms/page')->getPageUrl($redirect[$after]);
                }
        }

        return $redirectUrl;
    }

    public function isUrlInternal($url)
    {
    	return (stripos($url, 'http') === 0); 
        /*if (strpos($url, 'http') !== false) {
            if ((strpos($url, Mage::app()->getStore()->getBaseUrl()) === 0)
                || (strpos($url, Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true)) === 0)
            ) {
                return true;
            }
        }
        return false;*/
    }

	public function moduleInvitationsEnabled()
	{
		$hasModule = Mage::helper('core')->isModuleEnabled('Plumrocket_Invitations');
		if($hasModule) {
			return Mage::helper('invitations')->moduleEnabled();
		}

		return false;
	}

	public function isFakeMail($email = null)
	{
		if(is_null($email)) {
			$session = Mage::getSingleton('customer/session');
			if($session->isLoggedIn()) {
				$email = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
			}
		}
		return (bool)(strpos($email, self::FAKE_EMAIL_PREFIX) === 0);
	}

	public function getDebugMode()
	{
		return self::DEBUG_MODE;
	}
	
}