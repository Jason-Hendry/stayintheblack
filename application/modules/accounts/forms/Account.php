<?php

class accounts_Form_Account extends Twitter_Form
{
  protected $_actionType = 'Create';

  public function init()
  {
    $this->addElement('hidden', 'id', array('required'=>false));
    $this->addElement('text', 'accountName', array('label'=>'Account Name','required'=>true));
    $this->addElement('text', 'institution', array('label'=>'Bank / Institution Name'));
  }

  public function setActionType($value) {
    $this->_actionType = $value; return $this;
  }
  public function getActionType() {
    return $this->_actionType;
  }

}

