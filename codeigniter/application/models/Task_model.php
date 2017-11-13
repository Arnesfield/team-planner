<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends MY_CRUD_Model {

  private $_tbl = 'tasks';

  public function fetch($where) {
    $query = $this->db
      ->select('
        t.id AS task_id,
        t.name AS task_name,
        t.description AS task_desc,
        t.created_by_user_id AS task_created_by_user_id,
        t.taken_by_user_id AS task_taken_by_user_id,
        t.created_at AS task_created_at,
        t.deadline_at AS task_deadline_at,
        t.started_at AS task_started_at,
        t.ended_at AS task_ended_at,
        t.status AS task_status
      ')
      ->from('tasks t')
      ->join('groups g', 'g.id = t.group_id')
      ->where($where)
      ->order_by('t.started_at', 'desc')
      ->order_by('t.created_at', 'desc')
      ->order_by('t.ended_at', 'desc')
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