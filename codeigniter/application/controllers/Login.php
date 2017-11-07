<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
  }
  
  public function index() {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    // $invalid for display
    $invalid = false;
    if ($this->form_validation->run() === TRUE) {
      $username = $this->input->post('username', true);
      $password = $this->input->post('password', true);

      $this->load->model('user_model');
      
      // fetch user
      $where = array('username' => $username);
      $user = $this->user_model->fetch($where);

      // verify if user is valid
      if ($user && password_verify($password, $user[0]['password'])) {
        // set session here
        echo "fetched";
        return;
      }
      else {
        $invalid = true;
      }
    }

    // show login form
    $form_login_data = array('invalid' => $invalid);
    $data = array(
      'title' => 'Login',
      'form_login' => $this->load->view('forms/login', $form_login_data, true)
    );
    $this->_view(array('templates/nav', 'pages/login'), array_merge($this->_nav_items, $data));

  }
}

?>