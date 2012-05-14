<?php

class Rain_Form extends Twitter_Form {

  public function __construct() {
    parent::__construct();
    $this->addElementPrefixPath('Rain_Form_Decorator',
                            'Rain/Form/Decorator/',
                            'decorator');
  }
  
}