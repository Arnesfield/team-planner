<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_CRUD_Model {

  private $_tbl = 'users';

  public function fetch($user) {
    return $this->_read($this->_tbl, array('where' => $user));
  }

  public function fetch_like($text, $ids, $where_in = TRUE) {
    // if $ids not array
    if (!is_array($ids)) {
      // convert to array
      $ids = array($ids);
    }

    $this->db->select('*')->from($this->_tbl);
    if ($text) {
      $this->db->where("(username LIKE '%$text%' or fname LIKE '%$text%' or lname LIKE '%$text%' or email LIKE '%$text%')");
    }

    if ($where_in) {
      $this->db->where_in('id', $ids);
    }
    else {
      $this->db->where_not_in('id', $ids);
    }
    
    $query = $this->db->get();

    // echo $this->db->last_query();
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