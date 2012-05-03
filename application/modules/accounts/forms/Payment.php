<?php

class Accounts_Form_Payment extends Twitter_Form
{

    public function init()
    {
      $this->addElement('text','paymentDate',array('label'=>'Payment Date'));
      $this->addElement('text','description',array('label'=>'Description'));
      $this->addElement('text','amount',array('label'=>'Amount'));

      $accountsMapper = new Accounts_Model_PaymentAccountMapper();
      $accounts = $accountsMapper->fetchAll();

      $options = array();
      foreach($accounts as $i=>$a) {
        $options[$a->getId()] = $a->getAccountName();
      }

      $this->addElement('select','idAccount',array('MultiOptions'=>$options,'label'=>'Account'));
      $this->addElement('submit','submit',array('Label'=>'Add Payment'));
    }


}

