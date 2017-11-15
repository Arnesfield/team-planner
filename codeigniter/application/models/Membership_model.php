<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership_model extends MY_CRUD_Model {

  private $_tbl = 'memberships';

  public function fetch($where, $where_in = FALSE) {
    $this->db
      ->select('
      m.id AS membership_id,
      u.id AS user_id,
      u.username AS username,
      u.fname AS fname,
      u.lname AS lname,
      m.type AS member_type,
      m.status AS member_status,
      g.id AS group_id,
      g.name AS group_name,
      g.description AS group_desc,
      g.g_image AS group_image,
      g.status AS group_status,
      ')
      ->from('memberships m')
      ->join('users u', 'u.id = m.user_id')
      ->join('groups g', 'g.id = m.group_id');

    if ($where) {
      $this->db->where($where);
    }

    if ($where_in) {
      $this->db->where_in($where_in['col'], $where_in['data']);
    }
    
    $this->db
      ->order_by('g.name', 'asc')
      ->order_by('m.type', 'asc')
      ->order_by('u.username', 'asc')
      ->order_by('u.fname', 'asc')
      ->order_by('u.lname', 'asc');
      
    $query = $this->db->get();
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