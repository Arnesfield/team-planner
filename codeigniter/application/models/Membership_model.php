<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership_model extends MY_CRUD_Model {

  private $_tbl = 'memberships';

  public function fetch($where) {
    $query = $this->db
      ->select('*')
      ->from('memberships m')
      ->join('users u', 'u.id = m.user_id')
      ->join('groups g', 'g.id = m.group_id')
      ->where($where)
      ->order_by('g.name', 'asc')
      ->get();
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

  public function update($data, $where) {
    return $this->_update($this->_tbl, $data, $where);
  }

  public function insert($data) {
    return $this->_create($this->_tbl, $data);
  }
}

?>