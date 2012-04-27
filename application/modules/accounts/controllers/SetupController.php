<?php

class Accounts_SetupController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function addbankaccountAction() {
      $this->view->bankForm = new Accounts_Form_Bankaccount();
      if($this->getRequest()->isPost()) {
        if ($this->view->bankForm->isValid($this->getRequest()->getPost())) {
          $mapper  = new Accounts_Model_BankAccountMapper();
          $mapper->save(new Account_Model_BankAccount($this->view->bankForm->getValues()));
          return $this->_helper->redirector('index');
        }
      }
      $this->view->bankForm->setAction($this->view->url());
    }

}

