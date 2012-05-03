<?php

class Accounts_Model_CreditCardAccountMapper extends Accounts_Model_PaymentAccountMapper
{
  protected $_dbCreditCardTable;
  protected $_model = 'Accounts_Model_CreditCardAccount';
  public function setDbCreditCardTable($dbTable)
  {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbCreditCardTable = $dbTable;
    return $this;
  }
 
  public function getDbCreditCardTable()
  {
    if (null === $this->_dbCreditCardTable) {
      $this->setDbCreditCardTable('Accounts_Model_DbTable_PaymentAccountCreditCard');
    }
    return $this->_dbCreditCardTable;
  }

  public function save(Accounts_Model_CreditCardAccount $account) {
    $idaccount = parent::save($account);
    $data = array(
                  'idaccount'=>$idaccount,
                  'interest_rate'=>$account->getInterestRate()
                  );
    if (null === ($id = $account->getId())) {
      $this->getDbCreditCardTable()->insert($data);
    } else {
      $this->getDbCreditCardTable()->update($data, array('idaccount = ?' => $id));
    }    
  }

  public function find($id, Accounts_Model_CreditCardAccount $account) {
    parent::find($id, $account);
    $result = $this->getDbCreditCardTable()->find($id);
    if(0 == count($result))
      return;
    $row = $result->current();
    $account->setInterestRate($row->interest_rate);
  }

  public function selectAll() {
    $select = parent::selectAll();
    $select->setIntegrityCheck(false);
    $select->joinNatural('payment_account_credit_card');
    return $select;
  }
  public function fetchAll() {
    $entries = parent::fetchAll();
    return $entries;
  }

}

