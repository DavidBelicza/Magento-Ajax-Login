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
 * Handle ajax login and registration.
 * Class Youama_Ajaxlogin_AjaxController
 * @author David Belicza
 */
class Youama_Ajaxlogin_AjaxController extends Mage_Core_Controller_Front_Action
{
    /**
     * Root: ajaxlogin/ajax/index
     */
    public function indexAction()
    {
        if (isset($_POST['ajax'])){
            // Login request
            if ($_POST['ajax'] == 'login' && Mage::helper('customer')->isLoggedIn() != true) {
                $login = Mage::getSingleton('youama_ajaxlogin/ajaxlogin');
                echo $login->getResult();
            // Register request
            } else if ($_POST['ajax'] == 'register' && Mage::helper('customer')->isLoggedIn() != true) {
                $register = Mage::getSingleton('youama_ajaxlogin/ajaxregister');
                echo $register->getResult();
            }
        }
    }
    
    public function viewAction()
    {
    }
}