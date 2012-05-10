<?php

class Accounts_Model_PaymentAccountBalance extends Application_Model_Abstract {
  
  protected $_modelItemName = 'Account Balance';
  protected $_id;
  protected $_idAccount;
  protected $_balance;
  protected $_balanceTimestamp;

  public function setId($value) {
    $this->_id = $value;
    return $this;
  }
  public function setIdAccount($value) {
    $this->_idAccount = $value;
    return $this;
  }
  public function setBalance($value) {
    $this->_balance = $value;
    return $this;
  }
  public function setBalanceTimestamp($value) {
    if(is_subclass_of($value,'Zend_Date')) {
      $this->_balanceTimestamp = $value;
    } else {
      $this->_balanceTimestamp = new Zend_Date($value);
    }
    return $this;
  }
  public function getId() { return $this->_id; }
  public function getIdAccount() { return $this->_idAccount; }
  public function getBalance() { return $this->_balance; }
  public function getBalanceTimestamp() { return $this->_balanceTimestamp; }

}