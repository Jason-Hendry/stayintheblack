<?php

class Accounts_SetupController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
      foreach(array('Bank','CreditCard','Loan') as $type) {
        $mapperType = "Accounts_Model_{$type}AccountMapper";
        $viewVar = "{$type}Accounts";
        $accounts = new $mapperType();
        $this->view->$viewVar = $accounts->fetchAll();
      }
    }
    public function deleteaccountAction() {
      $type = $this->getRequest()->getParam('type');
      $mapperType = "Accounts_Model_{$type}AccountMapper";
      $modelType = "Accounts_Model_{$type}Account";

      $mapper  = new $mapperType();
      $account = new $modelType();
      $mapper->find($this->getRequest()->getParam('id'),$account);
      $account->delete();
      $mapper->save($account);
      $flashMessenger = $this->_helper->FlashMessenger;
      $flashMessenger->addMessage(array('notice'=>"$type Account &ldquo;{$account->accountName}&rdquo; removed."));
      $this->_helper->redirector('index');
    }
    public function editaccountAction() {
      $type = $this->getRequest()->getParam('type');
      $mapperType = "Accounts_Model_{$type}AccountMapper";
      $modelType = "Accounts_Model_{$type}Account";
      $formType = "Accounts_Form_{$type}Account";
      $mapper  = new $mapperType();
      $account = new $model();

      $this->view->type = $type;
      
      $this->view->accountForm = $formType(array('actionType'=>'Save'));
      $mapper  = new $mapperType();
      if($this->getRequest()->isPost()) {
        if ($this->view->accountForm->isValid($this->getRequest()->getPost())) {
          $mapper->save(new $model($this->view->accountForm->getValues()));
          return $this->_helper->redirector('index');
        }
      } else {
        //        
        $account = new $mode();
        $mapper->find($this->getRequest()->getParam('id'),$account);
        $this->view->accountForm->populate($account->toArray());
      }
      $this->view->accountForm->setAction($this->view->url());
    }
    public function addaccountAction() {
      $type = $this->getRequest()->getParam('type');
      $mapperType = "Accounts_Model_{$type}AccountMapper";
      $modelType = "Accounts_Model_{$type}Account";
      $formType = "Accounts_Form_{$type}Account";
      $mapper  = new $mapperType();
      $account = new $modelType();
      

      $this->view->type = preg_replace('/(.)([A-Z])/','$1 $2',$type);

      $this->view->accountForm = new $formType(array('actionType'=>'Create'));
      if($this->getRequest()->isPost()) {
        if ($this->view->accountForm->isValid($this->getRequest()->getPost())) {
          $mapper  = new $mapperType();
          $mapper->save(new $modelType($this->view->accountForm->getValues()));
          return $this->_helper->redirector('index');
        }
      }
      $this->view->accountForm->setAction($this->view->url());
    }

}

