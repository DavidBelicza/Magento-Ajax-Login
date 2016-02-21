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

require_once Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AccountController.php';

/**
 * Override Customer Account controller for disable login and register pages.
 * Class Youama_Ajaxlogin_AccountController
 * @author doveid
 * @see Mage_Customer_AccountController
 */
class Youama_Ajaxlogin_AccountController extends Mage_Customer_AccountController
{
    /**
     * @var string
     */
    protected $_url;

    /**
     * Before actions.
     * @return Mage_Core_Controller_Front_Action|void
     */
    public function preDispatch()
    {
        $this->_url = Mage::getBaseUrl() . '?yregister';
        
        parent::preDispatch();
    }

    /**
     * Disable login action.
     */
    public function loginAction()
    {
        $this->_setLocation();
    }

    /**
     * Disable create action.
     */
    public function createAction()
    {
        $this->_setLocation();
    }

    /**
     * Redirect to home.
     */
    protected function _setLocation()
    {
        Mage::app()->getFrontController()->getResponse()->setRedirect($this->_url);
    }
}
