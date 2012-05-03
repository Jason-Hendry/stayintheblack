<?php

class Accounts_Model_DbTable_PaymentAccountLoan extends Zend_Db_Table_Abstract
{

    protected $_name = 'payment_account_loan';

    public function getName() { return $this->_name; }
}

