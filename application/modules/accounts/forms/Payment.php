<?php

class Accounts_Form_Payment extends Rain_Form
{

    public function init()
    {
      $this->addElement('text','paymentDate',array('label'=>'Payment Date'));
      $this->addElement('text','description',array('label'=>'Description'));
      $this->addElement('text','amount',array('label'=>'Amount'));

      $accountsMapper = new Accounts_Model_PaymentAccountMapper();
      $accounts = $accountsMapper->fetchAll();

      $options = array();
      foreach($accounts as $i=>$a) {
        $options[$a->getId()] = $a->getAccountName();
      }

      $this->addElement('select','idAccount',array('MultiOptions'=>$options,'label'=>'Account'));


      $this->addElement('hidden','recurring',array('label'=>'Recurring'));
      $this->getElement('recurring')->setDecorators(
        array(
          "ViewHelper",
          "Recurring",
          array("Errors", array("placement" => "append")),
          array("Description", array("tag" => "span", "class" => "help-block")),
          array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "controls")),
          array("Label", array("class" => "control-label")),
          array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "control-group"))
        )
      );

      $this->addElement('submit','submit',array('Label'=>'Add Payment'));
    }


}

