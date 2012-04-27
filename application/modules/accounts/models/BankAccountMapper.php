<?php

class Accounts_Model_BankAccountMapper
{
  protected $_dbTable;
  protected $_dbBankTable;

  public function setDbTable($dbTable)
  {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbTable = $dbTable;
    return $this;
  }
 
  public function getDbTable()
  {
    if (null === $this->_dbTable) {
      $this->setDbTable('Accounts_Model_DbTable_PaymentAccount');
    }
    return $this->_dbTable;
  }

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
    if (null === $this->_dbTable) {
      $this->setDbBankTable('Accounts_Model_DbTable_PaymentAccountBank');
    }
    return $this->_dbBankTable;
  }

  public function save(Accounts_Model_BankAccount $account) {
     $data = array(
                   'account_name' => $account->getAccountName(),
                   'institution' => $account->getInstitution(),
                   'created' => date('U'),
                   'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                   );
 
     if (null === ($id = $account->getId())) {
       unset($data['id']);
       $this->getDbTable()->insert($data);
     } else {
       $this->getDbTable()->update($data, array('id = ?' => $id));
     }
  }

  public function find($id, Accounts_Model_BankAccount $account)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result)) {
      return;
    }
    $row = $result->current();
    $account->setId($row->idaccount)
      ->setAccountName($row->account_name)
      ->setInstitution($row->institution)
      ->setCreated($row->created);
  }
 
  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll();
    $entries   = array();
    foreach ($resultSet as $row) {
      $entry = new Accounts_Model_BankAccount();
      $entry->setId($row->idaccount)
        ->setAccountName($row->account_name)
        ->setInstitution($row->institution)
        ->setCreated($row->created);

      $entries[] = $entry;
    }
    return $entries;
  }

}

