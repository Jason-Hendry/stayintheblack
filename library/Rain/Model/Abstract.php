<?php

class Rain_Model_Abstract 
{

  protected $modelItemName;

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
      throw new Exception("Invalid {$this->_modelItemName} property");
    }
    $this->$method($value);
  }
  public function __get($name) {
    $method = 'get' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception("Invalid {$this->_modelItemName} property");
    }
    return $this->$method();
  }

  public function toArray() {
    $result = array();
    $methods = get_class_methods($this);
    foreach($methods as $method) {
      if(substr($method,0,3)=='get') {
        $result[strtolower(substr($method,3,1)).substr($method,4)] = $this->$method();
      }
    }
    return $result;
  }

}