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
 * Validate user data.
 * Class Youama_Ajaxlogin_Model_Validator
 * @author doveid
 */
class Youama_Ajaxlogin_Model_Validator extends Varien_Object
{
    /**
     * @var string
     */
    protected $_userEmail;

    /**
     * @var string
     */
    protected $_userPassword;

    /**
     * @var string
     */
    protected $_userFirstName;

    /**
     * @var string
     */
    protected $_userLastName;

    /**
     * @var bool
     */
    protected $_userNewsletter;

    /**
     * @var int
     */
    protected $_userId;

    /**
     * @var string
     */
    protected $_result;

    /**
     * Init.
     */
    public function _construct() 
    {
        parent::_construct();
    }

    /**
     * Validate email address.
     * @param string $email
     */
    protected function setEmail($email = '')
    {
        if (!Zend_Validate::is($email, 'EmailAddress')) {
            $this->_result .= 'wrongemail,';
        } else {
            $this->_userEmail = $email;
        }
    }

    /**
     * Validate user password.
     * @param $password string
     */
    protected function setSinglePassword($password)
    {
        $sanitizedPassword = str_replace(array('\'', '%', '\\', '/', ' '), '', $password);
        
        if (strlen($sanitizedPassword) > 16 || $sanitizedPassword != trim($password)) {
            $this->_result .= 'wrongemail,';
        }
        
        $this->_userPassword = $sanitizedPassword;
    }

    /**
     * Parsing passwords. Retrieve TRUE if there is an error. The error string
     * code will be saved into the property.
     * @param string $password
     * @param string $confirmation
     * @return bool|null
     */
    protected function setPassword($password = '', $confirmation = '')
    {
        // Sanitize password
        $sanitizedPassword = str_replace(array('\'', '%', '\\', '/', ' '), '', $password);

        // Special characters
        if ($password != $sanitizedPassword) {
            $this->_result .= 'dirtypassword,';
            return true;
        }

        // Too short
        if (strlen($sanitizedPassword) < 6) {
            $this->_result .= 'shortpassword,';
            return true;
        }

        // Too long
        if (strlen($sanitizedPassword) > 16) {
            $this->_result .= 'longpassword,';
            return true;
        }

        // Two passwords does not match
        if ($sanitizedPassword != $confirmation) {
            $this->_result .= 'notsamepasswords,';
            return true;
        }
        
        $this->_userPassword = $sanitizedPassword;
    }

    /**
     * Sanitize and validate user personal data.
     * @param string $firstname
     * @param string $lastname
     * @return bool|null
     */
    protected function setName($firstname = '', $lastname = '')
    {
        $firstname = trim($firstname);
        $lastname = trim($lastname);

        // Validate process
        $stop = false;

        // There is no first name
        if ($firstname == '') {
            $this->_result .= 'nofirstname,';
            $stop = true;
        }

        // There is no last name
        if ($lastname == '') {
            $this->_result .= 'nolastname,';
            $stop = true;
        }

        // Error, stop process
        if ($stop == true) {
            return true;
        }

        // Clear first name
        $sanitizedFname = str_replace(array('\'', '%', '\\', '/'), '', $firstname);

        // Validate first name
        if ($sanitizedFname != $firstname) {
            $this->_result .= 'dirtyfirstname,';
            $stop = true;
        }

        // Clear last name
        $sanitizedLname = str_replace(array('\'', '%', '\\', '/'), '', $lastname);

        // Validate last name
        if ($sanitizedLname != $lastname) {
            $this->_result .= 'dirtylastname,';
            $stop = true;
        }

        // User data are valid, set to property
        if ($stop != true) {
            $this->_userFirstName = $firstname;
            $this->_userLastName = $lastname;
        }
    }

    /**
     * @param string $newsletter
     */
    protected function setNewsletter($newsletter = 'no')
    {
        if ($newsletter == 'ok') {
            $this->_userNewsletter = true;
        } else {
            $this->_userNewsletter = false;
        }
    }

    /**
     * Validate email. Retrieve TRUE if email is already exist.
     * @return bool
     */
    protected function isEmailExist()
    {
        $customer = Mage::getModel('customer/customer');
        
        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
        $customer->loadByEmail($this->_userEmail);
        
        if($customer->getId()) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve result for Javascript.
     * @return string
     */
    public function getResult()
    {
        return $this->_result;
    }
}