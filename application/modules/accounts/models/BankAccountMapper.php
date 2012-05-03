<?php

class Accounts_Model_BankAccountMapper extends Accounts_Model_PaymentAccountMapper
{
  protected $_dbBankTable;
  protected $_model = 'Accounts_Model_BankAccount';
  public function setDbBankTable($dbTable)
  {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbBankTable = $dbTable;
    return $this;
  }
 
  public function getDbBankTable()
  {
    if (null === $this->_dbBankTable) {
      $this->setDbBankTable('Accounts_Model_DbTable_PaymentAccountBank');
    }
    return $this->_dbBankTable;
  }

  public function save(Accounts_Model_BankAccount $account) {
    $idaccount = parent::save($account);
    $data = array(
                  'idaccount'=>$idaccount,
                  'interest_rate'=>$account->getInterestRate()
                  );
    if (null === ($id = $account->getId())) {
      $this->getDbBankTable()->insert($data);
    } else {
      $this->getDbBankTable()->update($data, array('idaccount = ?' => $id));
    }    
  }

  public function find($id, Accounts_Model_BankAccount $account) {
    parent::find($id, $account);
    $result = $this->getDbBankTable()->find($id);
    if(0 == count($result))
      return;
    $row = $result->current();
    $account->setInterestRate($row->interest_rate);
  }

  public function selectAll() {
    $select = parent::selectAll();
    $select->setIntegrityCheck(false);
    $select->joinNatural('payment_account_bank');
    return $select;
  }
  public function fetchAll() {
    $entries = parent::fetchAll();
    return $entries;
  }

}

