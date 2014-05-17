<?php

/**
 * YouAMA.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA that is bundled with this package
 * on http://youama.com/freemodule-license.txt.
 *
 /****************************************************************************
 *                      MAGENTO EDITION USAGE NOTICE                         *
 ****************************************************************************/
 /* This package designed for Magento Community edition. Developer(s) of
 * YouAMA.com does not guarantee correct work of this extension on any other
 * Magento edition except Magento Community edition. YouAMA.com does not 
 * provide extension support in case of incorrect edition usage.
 /****************************************************************************
 *                               DISCLAIMER                                  *
 ****************************************************************************/
 /* Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *****************************************************
 * @category   Youama
 * @package    Youama_Ajaxlogin
 * @copyright  Copyright (c) 2012-2013 YouAMA.com (http://www.youama.com)
 * @license    http://youama.com/freemodule-license.txt
 */

class Youama_Ajaxlogin_Model_Validator extends Varien_Object
{    
    protected $_userEmail;
    
    protected $_userPassword;
    
    protected $_userFirstName;
    
    protected $_userLastName;
    
    protected $_userNewsletter;
    
    protected $_userId;
    
    protected $_result;
    
    public function _construct() 
    {
        parent::_construct();
    }
    
    protected function setEmail($email = '')
    {
        if (!Zend_Validate::is($email, 'EmailAddress'))
        {
            $this->_result .= 'wrongemail,';
        }
        else
        {
            $this->_userEmail = $email;
        }
    }
    
    protected function setSinglePassword($password){
        $sanitizedPassword = str_replace(array('\'', '%', '\\', '/', ' '), '', $password);
        
        if (strlen($sanitizedPassword) > 16 || $sanitizedPassword != trim($password))
        {
            $this->_result .= 'wrongemail,';
        }
        
        $this->_userPassword = $sanitizedPassword;
    }
    
    protected function setPassword($password = '', $confirmation = '')
    {        
        $sanitizedPassword = str_replace(array('\'', '%', '\\', '/', ' '), '', $password);
        
        if ($password != $sanitizedPassword)
        {
            $this->_result .= 'dirtypassword,';
            return true;
        }
        
        if (strlen($sanitizedPassword) < 6)
        {
            $this->_result .= 'shortpassword,';
            return true;
        }
        
        if (strlen($sanitizedPassword) > 16)
        {
            $this->_result .= 'longpassword,';
            return true;
        }
        
        if ($sanitizedPassword != $confirmation)
        {
            $this->_result .= 'notsamepasswords,';
            return true;
        }
        
        $this->_userPassword = $sanitizedPassword;
    }
    
    protected function setName($firstname = '', $lastname = '')
    {
        $firstname = trim($firstname);
        $lastname = trim($lastname);
        
        $stop = false;
        
        if ($firstname == '')
        {
            $this->_result .= 'nofirstname,';
            $stop = true;
        }
        
        if ($lastname == '')
        {
            $this->_result .= 'nolastname,';
            $stop = true;
        }
        
        if ($stop == true)
        {
            return true;
        }
        
        $sanitizedFname = str_replace(array('\'', '%', '\\', '/'), '', $firstname);
        
        if ($sanitizedFname != $firstname)
        {
            $this->_result .= 'dirtyfirstname,';
            $stop = true;
        }
        
        $sanitizedLname = str_replace(array('\'', '%', '\\', '/'), '', $lastname);
        
        if ($sanitizedLname != $lastname)
        {
            $this->_result .= 'dirtylastname,';
            $stop = true;
        }
        
        if ($stop != true)
        {
            $this->_userFirstName = $firstname;
            $this->_userLastName = $lastname;
        }
    }
    
    protected function setNewsletter($newsletter = 'no')
    {
        if ($newsletter == 'ok')
        {
            $this->_userNewsletter = true;
        }
        else
        {
            $this->_userNewsletter = false;
        }
    }
    
    protected function isEmailExist()
    {
        $customer = Mage::getModel('customer/customer');
        
        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
        $customer->loadByEmail($this->_userEmail);
        
        if($customer->getId())
        {
            return true;
        }

        return false;
    }
    
    public function getResult()
    {
        return $this->_result;
    }
}
?>