<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combo_model extends MY_CRUD_Model {

  public function fetch_users() {
    $sql = "
      SELECT
        u.id AS id,
        u.username AS username,
        u.fname AS fname,
        u.lname AS lname,
        u.email AS email,
        u.bio AS bio,
        u.u_image AS u_image,
        u.type AS type,
        u.status AS status,
        (SELECT count(*) FROM memberships m WHERE m.user_id = u.id) AS no_of_memberships
      FROM
        users u
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

  public function fetch_groups() {
    $sql = "
      SELECT
        g.id AS id,
        g.name AS name,
        g.description AS g_desc,
        g.g_image AS g_image,
        g.status AS status,
        (SELECT count(*) FROM memberships m WHERE g.id = m.group_id) AS member_count
      FROM
        groups g
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

  public function fetch_activities() {
    $sql = "
      SELECT
        *
      FROM
        activities
      ORDER BY
        date DESC,
        type ASC
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

  public function fetch_memberships() {
    $sql = "
      SELECT
        m.id AS id,
        u.id AS user_id,
        u.username AS username,
        g.id AS group_id,
        g.name AS group_name,
        m.type AS type,
        m.status AS status
      FROM
        memberships m, users u, groups g
      WHERE
        u.id = m.user_id AND
        g.id = m.group_id
      ORDER BY
        g.name ASC,
        m.type ASC,
        u.username ASC
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

  public function fetch_tasks() {
    $sql = "
      SELECT
        *
      FROM
        tasks
      ORDER BY
        started_at DESC,
        created_at DESC,
        deadline_at DESC,
        ended_at DESC
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

}

?>