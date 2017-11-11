<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_CRUD_Model {

  private $_tbl = 'users';

  public function fetch($user) {
    return $this->_read($this->_tbl, array('where' => $user));
  }

  public function update($data, $where) {
    return $this->_update($this->_tbl, $data, $where);
  }

  public function insert($data) {
    return $this->_create($this->_tbl, $data);
  }
}

?>