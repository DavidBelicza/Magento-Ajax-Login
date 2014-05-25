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
