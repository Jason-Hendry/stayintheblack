<?php

class accounts_Form_Account extends Twitter_Form
{

    public function init()
    {
      $this->addElement('text', 'account_name', array('label'=>'Account Name','required'=>true));
      $this->addElement('text', 'institution', array('label'=>'Bank / Institution Name'));
    }


}

