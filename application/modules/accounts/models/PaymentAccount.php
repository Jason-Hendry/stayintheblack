<?php

class Accounts_Model_PaymentAccount extends Rain_Model_Abstract
{
  protected $_id;
  protected $_accountName;
  protected $_institution;
  protected $_created;
  protected $_deleted = false;
  protected $modelItemName = 'Payment Account';

  public function setId($value) { $this->_id = $value; return $this; }
  public function setAccountName($value) { $this->_accountName = $value; return $this; }
  public function setInstitution($value) { $this->_institution = $value; return $this; }
  public function setCreated($value) { $this->_created = $value; return $this; }
  public function setDeleted($value) { $this->_deleted = $value; return $this; }

  public function getId() { return ((int)$this->_id)>0 ? (int)$this->_id : null; }
  public function getAccountName() { return $this->_accountName; }
  public function getInstitution() { return $this->_institution; }
  public function getCreated() { return $this->_created; }
  public function getDeleted() { return $this->_deleted; }

}

