<?php

/**
 * YouAMA.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA that is bundled with this package
 * on http://youama.com/freemodule-license.txt.
 *
 *******************************************************************************
 *                          MAGENTO EDITION USAGE NOTICE
 *******************************************************************************
 * This package designed for Magento Community edition. Developer(s) of
 * YouAMA.com does not guarantee correct work of this extension on any other
 * Magento edition except Magento Community edition. YouAMA.com does not
 * provide extension support in case of incorrect edition usage.
 *******************************************************************************
 *                                  DISCLAIMER
 *******************************************************************************
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *******************************************************************************
 * @category   Youama
 * @package    Youama_Ajaxlogin
 * @copyright  Copyright (c) 2012-2014 YouAMA.com (http://www.youama.com)
 * @license    http://youama.com/freemodule-license.txt
 */

/**
 * Block class for ajaxlogin view.
 * Class Youama_Ajaxlogin_Block_Ajaxlogin
 * @author doveid
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