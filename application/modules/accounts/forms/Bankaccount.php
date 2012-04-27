<?php

class Accounts_Form_Bankaccount extends Accounts_Form_Account
{

    public function init()
    {
      parent::init();
      $this->addElement('submit','submit',array('label'=>'Create Account'));
    }


}

