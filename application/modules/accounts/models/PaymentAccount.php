<?php

class Accounts_Model_PaymentAccount
{
  protected $_id;
  protected $_accountName;
  protected $_institution;
  protected $_created;
  protected $_itemName = 'Payment Account';

  public function __construct(array $options = null) {
    if (is_array($options)) {
      $this->setOptions($options);
    }
  }
  public function setOptions(array $options)
  {
    $methods = get_class_methods($this);
    foreach ($options as $key => $value) {
      $method = 'set' . ucfirst($key);
      if (in_array($method, $methods)) {
        $this->$method($value);
      }
    }
    return $this;
  }
  public function __set($name,$value) {
    $method = 'set' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception("Invalid {$this->_itemName} property");
    }
    $this->$method($value);
  }
  public function __get($name) {
    $method = 'get' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception("Invalid {$this->_itemName} property");
    }
    return $this->$method();
  }

  public function setAccountName($value) { $this->_accountName = $value; return $this; }
  public function setInstitution($value) { $this->_institution = $value; return $this; }
  public function setId($value) { $this->_id = $value; return $this; }
  public function setCreated($value) { $this->_created = $value; return $this; }

  public function getAccountName() { return $this->_accountName; }
  public function getInstitution() { return $this->_institution; }
  public function getId() { return $this->_id; }
  public function getCreated() { return $this->_created; }

}

