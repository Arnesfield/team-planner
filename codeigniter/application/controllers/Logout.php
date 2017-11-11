<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
  }
  
  public function index() {
    // unset userdata except $msg
    $this->_unset_session_but('msg');
    $this->session->set_flashdata('msg', 'Logged out successfully.');
    $this->_redirect();
  }
}

?>