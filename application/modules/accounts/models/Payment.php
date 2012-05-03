<?php

class Accounts_Model_Payment
{
  protected $_id;
  protected $_idAccount;
  protected $_paymentDate;
  protected $_description;
  protected $_amount;
  protected $_created;
  protected $_deleted;

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
      throw new Exception("Invalid Payment property");
    }
    $this->$method($value);
  }
  public function __get($name) {
    $method = 'get' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception("Invalid Payment property");
    }
    return $this->$method();
  }

  public function delete() { $this->_deleted = true; }
  public function isDeleted() { return $this->_deleted; }

  public function setPaymentDate($value) { $this->_paymentDate = is_numeric($value) ? $value : strtotime($value); return $this; }
  public function setDescription($value) { $this->_description = $value; return $this; }
  public function setAmount($value) { $this->_amount = $value; return $this; }
  public function setIdAccount($value) { $this->_idAccount = $value; return $this; }
  public function setId($value) { $this->_id = $value; return $this; }
  public function setCreated($value) { $this->_created = $value; return $this; }

  public function getPaymentDate() { return (int)$this->_paymentDate; }
  public function getDescription() { return $this->_description; }
  public function getAmount() { return $this->_amount; }
  public function getIdAccount() { return $this->_idAccount; }
  public function getId() { return ((int)$this->_id)>0 ? (int)$this->_id : null; }
  public function getCreated() { return $this->_created; }

  public function toArray() {
    return array(
                 'id'=>$this->getId(),
                 'paymentDate'=>$this->getPaymentDate(),
                 'description'=>$this->getDescription(),
                 'amount'=>$this->getAmount(),
                 'idAccount'=>$this->getIdAccount(),
                 );
  }

}

