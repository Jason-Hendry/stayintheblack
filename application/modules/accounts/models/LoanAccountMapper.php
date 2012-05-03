<?php

class Accounts_Model_LoanAccountMapper extends Accounts_Model_PaymentAccountMapper
{
  protected $_dbLoanTable;
  protected $_model = 'Accounts_Model_LoanAccount';
  public function setDbLoanTable($dbTable)
  {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbLoanTable = $dbTable;
    return $this;
  }
 
  public function getDbLoanTable()
  {
    if (null === $this->_dbLoanTable) {
      $this->setDbLoanTable('Accounts_Model_DbTable_PaymentAccountLoan');
    }
    return $this->_dbLoanTable;
  }

  public function save(Accounts_Model_LoanAccount $account) {
    $idaccount = parent::save($account);
    $data = array(
                  'idaccount'=>$idaccount,
                  'interest_rate'=>$account->getInterestRate()
                  );
    if (null === ($id = $account->getId())) {
      $this->getDbLoanTable()->insert($data);
    } else {
      $this->getDbLoanTable()->update($data, array('idaccount = ?' => $id));
    }    
  }

  public function find($id, Accounts_Model_LoanAccount $account) {
    parent::find($id, $account);
    $result = $this->getDbLoanTable()->find($id);
    if(0 == count($result))
      return;
    $row = $result->current();
    $account->setInterestRate($row->interest_rate);
  }

  public function selectAll() {
    $select = parent::selectAll();
    $select->setIntegrityCheck(false);
    $select->joinNatural('payment_account_loan');
    return $select;
  }
  public function fetchAll() {
    $entries = parent::fetchAll();
    return $entries;
  }

}

