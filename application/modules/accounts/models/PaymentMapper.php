<?php

class Accounts_Model_PaymentMapper extends Rain_Model_AbstractMapper
{
  protected $_modelClass = 'Accounts_Model_Payment';
  protected $_dbTableClass = 'Accounts_Model_DbTable_Payment';
  protected $_dbTablePrimaryKey = 'idpayment';

  protected function modelToRow($model) {
    return array(
                 'payment_date'=>$model->getPaymentDate()->getTimestamp(),
                 'description'=>$model->getDescription(),
                 'amount'=>$model->getAmount(),
                 'recurring' => json_encode($model->getRecurring()),
                 'idaccount'=>$model->getIdAccount(),
                 'created' => date('U'),
                 'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                 'deleted'=> $model->getDeleted() ? 'TRUE' : 'FALSE',
                 );
    
  }
  public function setModelValues($row,Rain_Model_Abstract $model) {
    $model->setId($row->idpayment)
      ->setPaymentDate($row->payment_date)
      ->setDescription($row->description)
      ->setAmount($row->amount)
      ->setIdAccount($row->idaccount)
      ->setCreated($row->created)
      ->setRecurring($row->recurring);
  }
  public function selectAll() {
    $select = parent::selectAll();
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