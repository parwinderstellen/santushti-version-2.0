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


class Plumrocket_SocialLogin_Block_System_Config_Version extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $moduleNode     = Mage::getConfig()->getNode('modules/Plumrocket_SocialLogin');
        $name           = $moduleNode->name;
        $version        = $moduleNode->version;
        $wiki           = $moduleNode->wiki;

        return $this->_includeJs() . '<div style="padding:10px;background-color:#fff;border:1px solid #ddd;margin-bottom:7px;">
            '. sprintf('Plumrocket %s v%s was developed by <a href="http://www.plumrocket.com" target="_blank">Plumrocket Inc</a>. For manual &amp; video tutorials please refer to <a href="%s" target="_blank">our online documentation</a>.', $name, $version, $wiki) .'
		</div>';
    }

    protected function _includeJs()
    {
        $baseJsUrl      = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS);
        $baseSkinUrl    = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
        
        return '<script type="text/javascript">
        var basePopupPath = "' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . '";
        var basePopupSkinPath = "' . $baseSkinUrl . '";
        var wysiwygEditorPath = "' . Mage::getUrl('adminhtml/catalog_category/wysiwyg') . '";
        </script>';
    }
}