<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_info_nav_items();
    $this->load->library('session');
    // check if session isset
    $this->_if_session_isset();
  }
  
  public function index() {
    $this->load->library(array('form_validation', 'recaptcha'));
    $this->load->database();

    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[16]|is_unique[users.username]');
    $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
    $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
    $this->form_validation->set_rules('g-recaptcha-response', 'reCAPTCHA', 'required|callback__check_recaptcha');

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('user_model');

      $verification_code = $this->_generate_code();
      $email = strip_tags($this->input->post('email'));
      $password = password_hash(strip_tags($this->input->post('password')), PASSWORD_DEFAULT);

      // insert user
      $data = array(
        'username' => strip_tags($this->input->post('username')),
        'fname' => strip_tags($this->input->post('fname')),
        'lname' => strip_tags($this->input->post('lname')),
        'email' => $email,
        'password' => $password,
        'verification_code' => $verification_code,
        'reset_expiration' => 0,
        // type :: 1 - admin, 2 - user
        'type' => 2,
        'status' => 2
      );

      if ($this->user_model->insert($data)) {
        // send email verification code
        $send_data = array('code' => $verification_code);
        // send email
        $sent = $this->_send_mail($email, 'Email Verification', 'email/email_verification', $send_data);
        // email sent
        if ($sent === TRUE) {
          // set message
          $this->session->set_flashdata('msg', 'Account successfully created! Please check your email to verify your account.');
          // go to login
          $this->_redirect('login');
          return;
        }
        // if not sent
        else {
          $this->session->set_flashdata('msg', 'An error occurred. Unable to send verification link to email.');
          // debug
          echo $sent;
        }
      }
      // failed to insert
      else {
        $this->session->set_flashdata('msg', 'An error occurred. Unable to create account.');
      }
      
    }

    $form_signup_data = array(
      'script' => $this->recaptcha->getScriptTag(),
      'widget' => $this->recaptcha->getWidget()
    );
    $data = array(
      'title' => 'Home',
      'form_signup' => $this->load->view('forms/signup', $form_signup_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/signup', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }

  // captcha callback
  public function _check_recaptcha($res) {
    if (!empty($res)) {
      $verify = $this->recaptcha->verifyResponse($res);

      if ($verify['success'] === TRUE) {
        return TRUE;
      }
    }

    $this->form_validation->set_message('_check_recaptcha', '{field} is invalid. Please try again.');
    return FALSE;
  }

  // verify
  public function verify() {
    // check if code exists in db
    if ($code = $this->uri->segment(3)) {
      $this->load->model('user_model');
      
      $where = array('verification_code' => $code);
      $user = $this->user_model->fetch($where);

      if ($user) {
        $user = $user[0];

        // update status to 1
        $data = array('status' => 1, 'verification_code' => '');
        $where = array('id' => $user['id']);
        
        if ($this->user_model->update($data, $where)) {
          // set message
          $this->session->set_flashdata('msg', 'Your account has been verified. You may now login.');
          // go to login
          $this->_redirect('login');
          return;
        }
        // error
        else {
          $this->session->set_flashdata('msg', 'An error occurred while retrieving account information.');
        }

      }
      // user does not exist or exist anymore
      else {
        $this->session->set_flashdata('msg', 'This verification code may have already expired and no longer exists.');
      }

    }
    // go to /
    $this->_redirect();
  }
}

?>