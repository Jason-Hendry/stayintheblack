<?php

class Accounts_Model_DbTable_PaymentAccount extends Zend_Db_Table_Abstract
{

    protected $_name = 'payment_account';

    public function getName() { return $this->_name; }

}

