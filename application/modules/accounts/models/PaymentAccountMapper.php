<?php

class Accounts_Model_PaymentAccountMapper
{
  protected $_dbTable;
  protected $_model = 'Accounts_Model_PaymentAccount';

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
 
  public function save(Accounts_Model_PaymentAccount $account)
  {
    $data = array(
                  'account_name'   => $account->getAccountName(),
                  'institution' => $account->getInstitution(),
                  'created' => date('U'),
                  'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                  'deleted'=> $account->isDeleted() ? 'TRUE' : 'FALSE',
                  );
    if (null === ($id = $account->getId())) {
      unset($data['idaccount']);
      return $this->getDbTable()->insert($data);
    } else {
      $this->getDbTable()->update($data, array('idaccount = ?' => $id));
      return $id;
    }
  }

  public function find($id, Accounts_Model_PaymentAccount $account)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result)) {
      return;
    }
    $row = $result->current();
    if($row->idusr !== Zend_Auth::getInstance()->getIdentity()->idusr) {
      throw new Zend_Exception('Unauthorized Access');
      return false;
    }
    $account->setId($row->idaccount)
      ->setAccountName($row->account_name)
      ->setInstitution($row->institution)
      ->setCreated($row->created);
    if($row->deleted)
      $account->delete();
  }
  public function selectAll() {
    $select = new Zend_Db_Table_Select($this->getDbTable());
    $select->from($this->getDbTable());
    $select->where('idusr=?',Zend_Auth::getInstance()->getIdentity()->idusr);
    $select->where('deleted=?','FALSE');
    return $select;
  }
  public function createModelFromRow($row) {
    $entry = new $this->_model();
    $entry->setId($row->idaccount)
      ->setAccountName($row->account_name)
      ->setInstitution($row->institution)
      ->setCreated($row->created);
    return $entry;
  }
  public function fetchAll()
  {
    $select = $this->selectAll();
    $resultSet = $this->getDbTable()->fetchAll($select);
    $entries   = array();
    foreach ($resultSet as $row) {
      $entries[] = $this->createModelFromRow($row);
    }
    return $entries;
  
}

}

