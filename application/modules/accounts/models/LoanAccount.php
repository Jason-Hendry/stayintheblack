<?php

class Accounts_Model_LoanAccount extends Accounts_Model_PaymentAccount
{
  protected $_itemName = 'Loan Account';

  protected $_interestRate;
  
  public function setInterestRate($value) { $this->_interestRate = $value; return $this; }
  public function getInterestRate() { return $this->_interestRate; }
  
  public function toArray() {
    return parent::toArray()+array(
                                   'interestRate'=>$this->getInterestRate(),
                                   );
  }

}

