<?php

class Accounts_Model_PaymentAccountMapper extends Rain_Model_AbstractMapper
{
  protected $_dbTable;
  protected $_modelClass = 'Accounts_Model_PaymentAccount';
  protected $_dbTableClass = 'Accounts_Model_DbTable_PaymentAccount';
  protected $_dbTablePrimaryKey = 'idaccount';

  protected function modelToRow($model) {
    $data = array(
                  'account_name' => $model->getAccountName(),
                  'institution' => $model->getInstitution(),
                  'created' => date('U'),
                  'idusr' => Zend_Auth::getInstance()->getIdentity()->idusr,
                  'deleted'=> $model->getDeleted() ? 'TRUE' : 'FALSE',
                  );
    return $data;
  }
  public function selectAll() {
    $select = parent::selectAll();
    $select->where('idusr=?',Zend_Auth::getInstance()->getIdentity()->idusr);
    $select->where('deleted=?','FALSE');
    return $select;
  }
  public function setModelValues($row, Rain_Model_Abstract $model) {
    $model->setId($row->idaccount)
      ->setAccountName($row->account_name)
      ->setInstitution($row->institution)
      ->setCreated($row->created);
  }
}

