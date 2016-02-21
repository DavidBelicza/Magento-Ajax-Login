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
 * Login user.
 * Class Youama_Ajaxlogin_Model_Ajaxlogin
 * @author David Belicza
 */
class Youama_Ajaxlogin_Model_Ajaxlogin extends Youama_Ajaxlogin_Model_Validator
{
    /**
     * Init.
     */
    public function _construct() 
    {
        parent::_construct();
        
        $this->setEmail($_POST['email']);
        $this->setSinglePassword($_POST['password']);

        // Start login process.
        if ($this->_result == '') {
            $this->_loginUser();
        }
    }

    /**
     * Try login user.
     */
    protected function _loginUser() {
        $session = Mage::getSingleton('customer/session');

        try {
            $session->login($this->_userEmail, $this->_userPassword);
            $customer = $session->getCustomer();
            
            $session->setCustomerAsLoggedIn($customer);
            
            $this->_result .= 'success';
        } catch(Exception $ex) {
            $this->_result .= 'wronglogin,';
        }
    }

    /**
     * String result for Javascript.
     * @return string
     */
    public function getResult()
    {
        return $this->_result;
    }
}
