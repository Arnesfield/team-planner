<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_info_nav_items();
    $this->load->library('session');
    // check if session isset
    $this->_if_session_isset();
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
        $this->load->library('session');
        $this->session->set_userdata(array('user' => $user[0]));
        $this->session->set_userdata(array('is_logged_in' => TRUE));
        // msg
        $this->session->set_flashdata('msg', 'Logged in successfully.');

        // go to
        $this->_redirect('dashboard');
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
      'form_login' => $this->load->view('forms/login', $form_login_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/login'),
      array_merge($this->_info_nav_items, $data)
    );
  }
}

?>