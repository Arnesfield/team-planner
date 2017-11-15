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
}

?>