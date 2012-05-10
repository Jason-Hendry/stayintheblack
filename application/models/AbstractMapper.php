<?php

abstract class Application_Model_AbstractMapper
{
  protected $_dbTable;
  protected $_model;
  protected $_dbTableClass;
  protected $_dbTablePrimaryKey;

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
      $this->setDbTable($this->_dbTableClass);
    }
    return $this->_dbTable;
  }

  abstract protected function modelToRow($model); 
  abstract public function setModelValues($row,Application_Model_Abstract $model);

  public function save(Application_Model_Abstract $model)
  {
    $data = $this->modelToRow($model);
    if (null === ($id = $model->getId())) {
      //      Zend_Debug::dump(); exit;
      return $this->getDbTable()->insert($data);
    } else {
      $this->getDbTable()->update($data, array("{$this->_dbTablePrimaryKey} = ?" => $id));
      return $id;
    }
  }

  public function find($id, Application_Model_Abstract $model)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result)) {
      return;
    }
    $row = $result->current();
    if(isset($row->idusr) && $row->idusr !== Zend_Auth::getInstance()->getIdentity()->idusr) {
      throw new Zend_Exception('Unauthorized Access');
      return false;
    }
    $this->setModelValues($row,$model);
    if(isset($row->deleted) && $row->deleted)
      $payment->delete();
  }
  public function selectAll() {
    $select = new Zend_Db_Table_Select($this->getDbTable());
    $select->from($this->getDbTable());
    $select->where('idusr=?',Zend_Auth::getInstance()->getIdentity()->idusr);
    $select->where('deleted=?','FALSE');
    return $select;
  }
  public function rowSetToModels($rowSet) {
    $entries   = array();
    foreach ($rowSet as $row) {
      $model = new $this->_model();
      $this->setModelValues($row,$model);
      $entries[] = $model;
    }
    return $entries;
  }

  public function fetchAll()
  {
    $select = $this->selectAll();
    return $this->rowSetToModels($this->getDbTable()->fetchAll($select));
  }

}



