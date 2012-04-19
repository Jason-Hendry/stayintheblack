<?php

class Accounts_IndexController extends Zend_Controller_Action
{

    public function init()
    {
      if(!Zend_Auth::getInstance()->hasIdentity()) {
          $this->_helper->FlashMessenger('Use must be logged into see your accounts');
          $this->_redirect('auth/login');
      }
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }


}

