<?php 

class Accounts_Model_PaymentAccountBalanceMapper extends Application_Model_AbstractMapper {
  protected $_model = 'Accounts_Model_PaymentAccountBalance';
  protected $_dbTableClass = 'Accounts_Model_DbTable_PaymentAccountBalance';
  protected $_dbTablePrimaryKey = 'idaccount_balance';

  protected function modelToRow($model) {
    return array(
                 'idaccount_balance'=>$model->getId(),
                 'idaccount'=>$model->getIdAccount(),
                 'balance'=>$model->getBalance(),
                 'balance_timestamp'=>$model->getBalanceTimestamp()->getTimestamp(),
                 );
  } 
  public function setModelValues($row, Application_Model_Abstract $model) {
    $model->setId($row->idaccount_balance);
    $model->setIdAccount($row->idaccount);
    $model->setBalance($row->balance);
    $model->setBalanceTimestamp($row->balance_timestamp);
  }
}

