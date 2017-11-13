<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership_model extends MY_CRUD_Model {

  private $_tbl = 'memberships';

  public function fetch($where) {
    $query = $this->db
      ->select('
        m.id AS membership_id,
        u.id AS user_id,
        u.username AS username,
        u.fname AS fname,
        u.lname AS lname,
        m.type AS member_type,
        g.id AS group_id,
        g.name AS group_name,
        g.description AS group_desc
      ')
      ->from('memberships m')
      ->join('users u', 'u.id = m.user_id')
      ->join('groups g', 'g.id = m.group_id')
      ->where($where)
      ->order_by('g.name', 'asc')
      ->order_by('m.type', 'asc')
      ->order_by('u.username', 'asc')
      ->order_by('u.fname', 'asc')
      ->order_by('u.lname', 'asc')
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