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
    
    if (!$this->input->post('id')) {
      $this->_redirect('dashboard');
      exit();
    }

    $id = $this->input->post('id');

    if (isset($this->input->post()['type'])) {
      $key = 'type';
      $value = $this->input->post('type');
    }
    else if (isset($this->input->post()['status'])) {
      $key = 'status';
      $value = $this->input->post('status');
    }

    $this->load->model('user_model');

    $data[$key] = $value;
    $where = array('id' => $id);

    if ($this->user_model->update($data, $where)) {
      echo json_encode(array('success' => 1));
    }
    else {
      echo json_encode(array('success' => 0));
    }
  }

  // users
  public function users() {
    $curr_user_id = $this->session->userdata('user')['id'];

    $this->load->model('combo_model');

    $members = $this->combo_model->fetch_users();

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
    $data = array(
      'title' => 'Manage Groups',
      'msg' => $this->session->flashdata('msg'),
    );
    $this->_view(
      array('templates/nav', 'pages/admin/groups', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }
}

?>