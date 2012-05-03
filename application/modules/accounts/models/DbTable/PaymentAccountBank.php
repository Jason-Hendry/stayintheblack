<?php

class Accounts_Model_DbTable_PaymentAccountBank extends Zend_Db_Table_Abstract
{

    protected $_name = 'payment_account_bank';

    public function getName() { return $this->_name; }
}

