<?php

/**
 * YOUAMA SOFTWARE
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the OSL 3.0 license.
 *
 *******************************************************************************
 * MAGENTO EDITION USAGE NOTICE
 *
 * This package designed for Magento Community Edition. Developer(s) of
 * YOUAMA.COM does not guarantee correct work of this extension on any other
 * Magento Edition except clear installed Magento Community Edition. YouAMA.com
 * does not provide extension support in case of incorrect usage.
 *******************************************************************************
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *******************************************************************************
 * @category   Youama
 * @package    Youama_Ajaxlogin
 * @copyright  Copyright (c) 2012-2016 David Belicza (http://www.youama.com)
 * @license    https://opensource.org/licenses/osl-3.0.php
 */

/**
 * Block class for ajaxlogin view.
 * Class Youama_Ajaxlogin_Block_Ajaxlogin
 * @author David Belicza
 */
class Youama_Ajaxlogin_Block_Ajaxlogin extends Mage_Core_Block_Template
{
    /**
     * Retrieve string 1 if Redirection to profile is YES on system config page.
     * @return string
     */
    public function isRedirectToProfile()
    {
        if (Mage::getStoreConfig('youamaajaxlogin/settings/redirection')) {
            return '1';
        }

        return '0';
    }
}