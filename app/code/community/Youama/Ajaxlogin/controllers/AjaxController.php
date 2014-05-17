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

class Youama_Ajaxlogin_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {             
        if (isset($_POST['ajax']))
        {
            if ($_POST['ajax'] == 'login' && Mage::helper('customer')->isLoggedIn() != true)
            {
                $login = Mage::getSingleton('youama_ajaxlogin/ajaxlogin');
                echo $login->getResult();
            }
            elseif ($_POST['ajax'] == 'register' && Mage::helper('customer')->isLoggedIn() != true)
            {
                $register = Mage::getSingleton('youama_ajaxlogin/ajaxregister');
                echo $register->getResult();
            }
        }
    }
    
    public function viewAction()
    {
    }
}

?>