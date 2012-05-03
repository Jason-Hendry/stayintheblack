<?php

class Accounts_Model_DbTable_PaymentAccountCreditCard extends Zend_Db_Table_Abstract
{

    protected $_name = 'payment_account_credit_card';

    public function getName() { return $this->_name; }
}

