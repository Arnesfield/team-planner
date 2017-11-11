<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_nav_items();
    $this->load->library('session');

    $user = $this->session->userdata('user');

    // redirect to login if not logged in
    if ($this->session->has_userdata('is_logged_in') === FALSE) {
      $this->_redirect('login');
    }
    // check status also
    // status :: 0 - deactivated, 1 - ok, 2 - email unverified
    else if ($user['status'] === 0) {
      $this->session->set_flashdata('msg', 'We are sorry. But this account has been blocked.');
      $this->_redirect('login');
    }
    else if ($user['status'] === 2) {
      $this->session->set_flashdata('msg', "Please verify your account's email first.");
      $this->_redirect('login');
    }
    // check type of account
    // type :: 1 - admin, 2 - user
    else if ($user['type'] === 1) {
      $this->_redirect('admin');
    }
  }
  
  public function index() {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    $data = array(
      'title' => 'Dashboard',
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/dashboard', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }
}

?>