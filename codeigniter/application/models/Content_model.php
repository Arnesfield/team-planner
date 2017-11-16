<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_model extends MY_CRUD_Model {

  public $_tbl = 'content';

  public function fetch($content) {
    return $this->_read($this->_tbl, array(
      'where' => $content,
      'order_by' => array('type', 'ASC')
    ));
  }

  public function update($data, $where) {
    return $this->_update($this->_tbl, $data, $where);
  }

  public function insert($data) {
    return $this->_create($this->_tbl, $data);
  }
}

?>