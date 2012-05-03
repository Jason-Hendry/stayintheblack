<?php

class Accounts_Model_PaymentMapper
{
  protected $_dbTable;
  protected $_model = 'Accounts_Model_Payment';

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
      $this->setDbTable('Accounts_Model_DbTable_Payment');
    }
    return $this->_dbTable;
  }
 
  public function save(Accounts_Model_Payment $payment)
  {
    $data = array(
                  'payment_date'=>$payment->getPaymentDate(),
                  'description'=>$payment->getDescription(),
                  'amount'=>$payment->getAmount(),
                  'idaccount'=>$payment->getIdAccount(),
                  'created' => date('U'),
                  'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                  'deleted'=> $payment->isDeleted() ? 'TRUE' : 'FALSE',
                  );
    if (null === ($id = $payment->getId())) {
      return $this->getDbTable()->insert($data);
    } else {
      $this->getDbTable()->update($data, array('idaccount = ?' => $id));
      return $id;
    }
  }

  public function find($id, Accounts_Model_Payment $payment)
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
    $payment->setId($row->idpayment)
      ->setPaymentDate($row->payment_name)
      ->setDescription($row->institution)
      ->setAmount($row->created)
      ->setIdAccount($row->created)
      ->setCreated($row->created);
    if($row->deleted)
      $payment->delete();
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
    $entry->setId($row->idpayment)
      ->setPaymentDate($row->payment_date)
      ->setDescription($row->description)
      ->setAmount($row->amount)
      ->setIdAccount($row->idaccount)
      ->setCreated($row->created);
    return $entry;
  }
  public function rowSetToModels($rowSet) {
    $entries   = array();
    foreach ($rowSet as $row) {
      $entries[] = $this->createModelFromRow($row);
    }
    return $entries;
  }

  public function fetchAll()
  {
    $select = $this->selectAll();
    return $this->rowSetToModels($this->getDbTable()->fetchAll($select));
  }

  public function fetchRange($start,$end) {
    $select = $this->selectAll();
    $select->where('payment_date>?',$start);
    $select->where('payment_date<?',$end);
    return $this->rowSetToModels($this->getDbTable()->fetchAll($select));
  }

}



