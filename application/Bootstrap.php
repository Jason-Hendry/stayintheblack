<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  public function init() {
    date_default_timezone_set('Australia/Melbourne');
  }

  public function _initDocType() {
    $this->bootstrap('view');
    $view = $this->getResource('view');
    $view->docType('HTML5');
  }

}

