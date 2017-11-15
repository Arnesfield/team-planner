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
        count(*) AS no_of_memberships
      FROM
        users u, memberships m
      WHERE
        u.id = m.user_id
      GROUP BY
        u.id
    ";
      
    $query = $this->db->query($sql);
    return $query->num_rows() > 0 ? $query->result_array() : FALSE;
  }

}

?>