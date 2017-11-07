<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
  }
  
  public function index() {
    $data = array(
      'title' => 'Home',
      'form_login' => $this->load->view('forms/login', null, true)
    );
    $this->_view(array('templates/nav', 'pages/info'), array_merge($this->_nav_items, $data));
  }
}

?>