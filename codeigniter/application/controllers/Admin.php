<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    
    // redirect to login if not logged in
    if ($this->session->has_userdata('is_logged_in') === FALSE) {
      $this->_redirect('login');
      return;
    }
    
    $user = $this->session->userdata('user');
    // go to dashboard if not admin
    if ($user['type'] != 1) {
      $this->_redirect('dashboard');
      return;
    }
    
    $this->_set_nav_items($user['type'] == 1);
  }
  
  public function index() {
    $this->_redirect('dashboard');
  }

  public function update() {
    if (!$this->input->post()) {
      $this->_redirect('dashboard');
      exit();
    }
    
    // check gid
    if (!($this->input->post('id', TRUE) || $this->input->post('gid', TRUE))) {
      $this->_redirect('dashboard');
      exit();
    }

    $id = $this->input->post('id', TRUE);
    // if id not set
    // use gid
    if (!$id) {
      $id = $this->input->post('gid', TRUE);
      $g = TRUE;
    }

    if (isset($this->input->post()['type'])) {
      $key = 'type';
      $value = $this->input->post('type');
    }
    else if (isset($this->input->post()['status'])) {
      $key = 'status';
      $value = $this->input->post('status');
    }

    if (isset($g) && $g) {
      $this->load->model('group_model');
    }
    else {
      $this->load->model('user_model');
    }

    $data[$key] = $value;
    $where = array('id' => $id);

    if ((isset($g) && $g) && $this->group_model->update($data, $where)) {
      $success = 1;
    }
    else if (!(isset($g) && $g) && $this->user_model->update($data, $where)) {
      $success = 1;
    }
    else {
      $success = 0;
    }

    echo json_encode(array('success' => $success));
  }

  // users
  public function users() {
    $curr_user_id = $this->session->userdata('user')['id'];

    $this->load->model('combo_model');

    $members = $this->combo_model->fetch_users();
    $members = $members ? $members : array();

    $data = array(
      'title' => 'Manage Users',
      'msg' => $this->session->flashdata('msg'),
      'users' => json_encode($members),
      'curr_user_id' => $curr_user_id
    );
    $this->_view(
      array('templates/nav', 'pages/admin/users', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // groups
  public function groups() {
    $this->load->model('combo_model');
    
    $groups = $this->combo_model->fetch_groups();
    $groups = $groups ? $groups : array();

    $data = array(
      'title' => 'Manage Groups',
      'msg' => $this->session->flashdata('msg'),
      'groups' => json_encode($groups),
    );
    $this->_view(
      array('templates/nav', 'pages/admin/groups', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }
}

?>