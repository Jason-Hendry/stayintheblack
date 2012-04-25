<?php

class Application_Form_Login extends Twitter_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
      $this->setMethod('post');
      $this->addElement('text','username',
                        array(
                              'label'=>'Username',
                              'required'=>true,
                              'filters'=>array('StringTrim')
                              ));
      $this->addElement('password','password',
                        array(
                              'label'=>'Password',
                              'required'=>true,
                              ));
      $this->addElement('submit','submit',array('label'=>'Login'));
      
    }


}

