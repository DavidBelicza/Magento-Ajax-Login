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

require_once Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AccountController.php';

class Youama_Ajaxlogin_AccountController extends Mage_Customer_AccountController
{        
    private $_url;
    
    public function preDispatch()
    {
        $this->_url = Mage::getBaseUrl() . '?yregister';
        
        parent::preDispatch();
    }
    
    public function loginAction()
    {
        $this->setLocation();
    }
    
    public function createAction()
    {
        $this->setLocation();
    }
    
    private function setLocation()
    {
        Mage::app()->getFrontController()->getResponse()->setRedirect($this->_url);
    }
}

?>
