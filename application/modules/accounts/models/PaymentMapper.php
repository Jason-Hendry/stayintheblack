<?php

class Accounts_Model_PaymentMapper extends Application_Model_AbstractMapper
{
  protected $_model = 'Accounts_Model_Payment';
  protected $_dbTableClass = 'Accounts_Model_DbTable_Payment';
  public function __construct() {
    $this->_dbTablePrimaryKey = 'idpayment';
  }

  protected function modelToRow($model) {
    return array(
                 'payment_date'=>$model->getPaymentDate()->getTimestamp(),
                 'description'=>$model->getDescription(),
                 'amount'=>$model->getAmount(),
                 'idaccount'=>$model->getIdAccount(),
                 'created' => date('U'),
                 'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                 'deleted'=> $model->isDeleted() ? 'TRUE' : 'FALSE',
                 );
    
  }
  public function setModelValues($row,Application_Model_Abstract $model) {
    $model->setId($row->idpayment)
      ->setPaymentDate($row->payment_date)
      ->setDescription($row->description)
      ->setAmount($row->amount)
      ->setIdAccount($row->idaccount)
      ->setCreated($row->created);
  }
  public function selectAll() {
    $select = new Zend_Db_Table_Select($this->getDbTable());
    $select->from($this->getDbTable());
    $select->where('idusr=?',Zend_Auth::getInstance()->getIdentity()->idusr);
    $select->where('deleted=?','FALSE');
    return $select;
  }

  public function fetchRange($start,$end) {
    $select = $this->selectAll();
    $select->where('payment_date>?',$start);
    $select->where('payment_date<?',$end);
    return $this->rowSetToModels($this->getDbTable()->fetchAll($select));
  }

}



