<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();

    if (!$this->input->post('mobile')) {
      $this->_redirect();
      exit();
    }
  }
  
  public function index() {
    exit();
  }

  private function _fail() {
    echo json_encode(array('success' => 0));
    exit();
  }

  public function login() {
    // accept username and password
    if (!(
      ($username = $this->input->post('username')) &&
      ($password = $this->input->post('password'))
    )) {
      $this->_fail();
    }

    $this->load->user_model();

    // fetch user
    $where = array('username' => $username);
    $user = $this->user_model->fetch($where);

    // verify if user is valid
    if ($user && password_verify($password, $user[0]['password'])) {
      echo json_encode(
        array(
          'success' => 1,
          'user' => $user[0]
        )
      );
    }
    else {
      $this->_fail();
    }
  }

}

?>