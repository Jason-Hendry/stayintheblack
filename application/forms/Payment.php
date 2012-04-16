<?php

class Application_Form_Payment extends Zend_Form
{

    public function init()
    {
      // Set the method for the display form to POST
      $this->setMethod('post');
      $this->addElement('text','amount',array(
                                              'label'=>'Amount','required'=>true
                                              ));
      // Add the submit button
      $this->addElement('submit', 'submit', array(
                                                  'ignore'   => true,
                                                  'label'    => 'Add Amount',
                                                  ));
      $this->addElement('hash', 'csrf', array(
                                              'ignore' => true,
                                              ));
    }


}

