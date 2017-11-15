<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');

    $user = $this->session->userdata('user');
    
    if (!$user) {
      $this->_redirect();
      return;
    }
  }
  
  public function index() {
    $user = $this->session->userdata('user');
    $this->_insert_activity('Logged out User '.$user['id'].'.' , 2);
    // unset userdata except $msg
    $this->_unset_session_but('msg');
    $this->session->set_flashdata('msg', 'Logged out successfully.');
    $this->_redirect();
  }
}

?>