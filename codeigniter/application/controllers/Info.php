<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_info_nav_items();
    $this->load->library('session');
    // check if session isset
    $this->_if_session_isset();
  }
  
  public function index() {
    $this->load->library('form_validation');
    $data = array(
      'title' => 'Home',
      'form_login' => $this->load->view('forms/login', null, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/info', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }
}

?>