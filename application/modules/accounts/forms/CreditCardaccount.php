<?php

class Accounts_Form_CreditCardaccount extends Accounts_Form_Account
{
  
  public function init()
  {
    parent::init();
    $this->addElement('text','interestRate',array('label'=>'Interest Rate'));
    $this->addElement('submit','submit',array('label'=>"{$this->_actionType} Account"));
  }
}

