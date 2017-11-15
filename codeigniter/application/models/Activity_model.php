<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends MY_CRUD_Model {

  public $_tbl = 'activities';

  public function fetch($activity) {
    return $this->_read($this->_tbl, array('where' => $activity));
  }

  public function update($data, $where) {
    return $this->_update($this->_tbl, $data, $where);
  }

  public function insert($data) {
    return $this->_create($this->_tbl, $data);
  }
}

?>