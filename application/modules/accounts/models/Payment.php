<?php

class Accounts_Model_Payment extends Rain_Model_Abstract
{
  protected $_id;
  protected $_idAccount;
  protected $_paymentDate;
  protected $_description;
  protected $_amount;
  protected $_created;
  protected $_deleted;
  protected $_recurring;
  protected $_modelItemName = 'Payment';

  public function setPaymentDate($value) { 
    if($value instanceOf Zend_Date) {
      $this->_paymentDate = $value;
    } else if($value == '') {
      $this->_paymentDate = new Zend_Date();
    } else {
      $this->_paymentDate = new Zend_Date($value);
    } 
    return $this; 
  }
  public function setRecurring($value) { 
    $recurring = JSON_decode($value);
    if($recurring->enabled)
      $this->_recurring = $recurring;
    else
      $this->_recurring = false;
    return $this;
  }
  public function setDescription($value) { $this->_description = $value; return $this; }
  public function setAmount($value) { $this->_amount = $value; return $this; }
  public function setIdAccount($value) { $this->_idAccount = $value; return $this; }
  public function setId($value) { $this->_id = $value; return $this; }
  public function setCreated($value) { $this->_created = $value; return $this; }
  public function setDeleted($value) { $this->_deleted = $value; return $this; }

  public function getPaymentDate() { return $this->_paymentDate; }
  public function getDescription() { return $this->_description; }
  public function getAmount() { return $this->_amount; }
  public function getIdAccount() { return $this->_idAccount; }
  public function getId() { return ((int)$this->_id)>0 ? (int)$this->_id : null; }
  public function getCreated() { return $this->_created; }
  public function getRecurring() { return $this->_recurring; }
  public function getDeleted() { return $this->_deleted; }

  

}

