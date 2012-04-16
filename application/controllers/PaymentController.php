<?php

class PaymentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
      $request = $this->getRequest();
      $form = new Application_Form_Payment();
      if ($this->getRequest()->isPost()) {
        if ($form->isValid($request->getPost())) {
          $comment = new Application_Model_Payment($form->getValues());
          $mapper  = new Application_Model_PaymentMapper();
          $mapper->save($comment);
          return $this->_helper->redirector('index');
        }
      }
      $this->view->form = $form;
    }


}



