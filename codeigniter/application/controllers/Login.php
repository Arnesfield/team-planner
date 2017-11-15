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

    if ($this->form_validation->run() === TRUE) {
      $username = $this->input->post('username', true);
      $password = $this->input->post('password', true);

      $this->load->model('user_model');
      
      // fetch user
      $where = array('username' => $username);
      $user = $this->user_model->fetch($where);

      // verify if user is valid
      if ($user && password_verify($password, $user[0]['password'])) {
        $user = $user[0];
        // set session here
        $this->load->library('session');

        // check conditions first
        // check status
        // status :: 0 - deactivated, 1 - ok, 2 - email unverified
        if ($user['status'] == 0) {
          $this->session->set_flashdata('msg', 'We are sorry, but this account has been suspended.');
          $this->_insert_activity('User '.$user['id'].' suspended account login attempt.' , 1);
          $this->_redirect('login');
          return;
        }
        else if ($user['status'] == 2) {
          $this->session->set_flashdata('msg', "Please verify your account's email first.");
          $this->_insert_activity('User '.$user['id'].' unverified account login attempt.' , 1);
          $this->_redirect('login');
          return;
        }

        $this->session->set_userdata(array('user' => $user));
        $this->session->set_userdata(array('is_logged_in' => TRUE));
        // msg
        $this->session->set_flashdata('msg', 'Logged in successfully.');
        
        $this->_insert_activity('Logged in User '.$user['id'].'.' , 1);

        // go to
        // check type of account
        // type :: 1 - admin, 2 - user
        // no need for type check for redirect
        $this->_redirect('dashboard');
        return;
      }
      else {
        // $invalid changed to flashdata
        $this->session->set_flashdata('msg', 'Invalid username or password.');
      }
    }

    // show login form
    $form_login_data = array();
    $data = array(
      'title' => 'Login',
      'form_login' => $this->load->view('forms/login', $form_login_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/login', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }
}

?>