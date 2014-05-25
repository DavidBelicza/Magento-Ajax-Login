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
 * Register user.
 * Class Youama_Ajaxlogin_Model_Ajaxregister
 * @author doveid
 */
class Youama_Ajaxlogin_Model_Ajaxregister
    extends Youama_Ajaxlogin_Model_Validator
{
    /**
     * Init.
     */
    public function _construct() 
    {
        parent::_construct();

        // Result for Javascript
        $this->_result = '';
        $this->_userId = -1;

        // Terms and conditions has been accepted
        if ($_POST['licence'] == 'ok') {
            $this->setEmail($_POST['email']);

            // If this email is already exist
            if ($this->isEmailExist()) {
                $this->_result .=  'emailisexist,';
            // If this email is not exist yet.
            } else {
                $this->setPassword($_POST['password'], $_POST['passwordsecond']);
                $this->setName($_POST['firstname'], $_POST['lastname']);
                $this->setNewsletter($_POST['newsletter']);

                // If there are no errors
                if ($this->_result == '') {
                    // Try register user
                    $this->_registerUser();

                    // Try subscribe user to newsletter
                    if ($this->_userNewsletter == true) {
                        $this->_subscribeUser();
                    }
                }
            }
        // Terms and conditions has not been accepted
        } else {
            $this->_result = 'nolicence,';
        }        
    }

    /**
     * Register user via Mage's API.
     */
    protected function _registerUser()
    {
        // Empty customer object
        $customer = Mage::getModel('customer/customer');

        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());

        // Set customer
        $customer->setEmail($this->_userEmail);
        $customer->setPassword($this->_userPassword);
        $customer->setFirstname($this->_userFirstName);
        $customer->setLastname($this->_userLastName);

        // Try create customer
        try {
            $customer->save();
            $customer->setConfirmation(null);
            $customer->save();
            
            $storeId = $customer->getSendemailStoreId();
            $customer->sendNewAccountEmail('registered', '', $storeId);
            
            Mage::getSingleton('customer/session')->loginById($customer->getId());
            
            $this->_userId = $customer->getId();
            
            $this->_result = 'success';
        // Error by injected HTML/JS
        } catch (Exception $ex) {
            $this->_result .= 'frontendhackerror,';
        }
    }

    /**
     * Subscribe user to newsletter.
     * @throws Exception
     */
    protected function _subscribeUser() {
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($this->_userEmail);

        if (!$subscriber->getId()) {
            $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
            $subscriber->setSubscriberEmail($this->_userEmail);
            $subscriber->setSubscriberConfirmCode($subscriber->RandomSequence());
        }

        $subscriber->setStoreId(Mage::app()->getStore()->getId());
        $subscriber->setCustomerId($this->_userId);

        // Try to save the subscribe
        try {
            $subscriber->save();
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
