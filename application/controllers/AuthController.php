<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
      $db = $this->_getParam('db');
 
      $loginForm = new Application_Form_Login();
      
      if ($loginForm->isValid($_POST)) {
        
        $adapter = new Zend_Auth_Adapter_DbTable(
                                                 $db,
                                                 'usr',
                                                 'username',
                                                 'password'
                                                 );
        
        $adapter->setIdentity($loginForm->getValue('username'));
        $adapter->setCredential(md5($loginForm->getValue('password')));
        
        $auth   = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        
        if ($result->isValid()) {
          $this->_helper->FlashMessenger('Successful Login');

          $auth->getStorage()->write($adapter->getResultRowObject(null,array('password')));
          $this->_redirect('/');
          return;
        }
        
      }
 
      $this->view->loginForm = $loginForm;
    }
    public function logoutAction() {
      Zend_Auth::getInstance()->clearIdentity();
      $this->_redirect('/');
      return;
    }

}





