<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_info_nav_items();
    $this->load->library('session');
    // check if session isset
    $this->_if_session_isset();
  }
  
  public function index() {
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

    if ($this->form_validation->run() === TRUE) {
      $email = $this->input->post('email', true);

      $this->load->model('user_model');

      // fetch db if email exists
      $where = array('email' => $email);
      $user = $this->user_model->fetch($where);

      // return the id and update verification code field
      if ($user) {
        $user = $user[0];
        $verification_code = substr(md5(uniqid(rand(), true)), -16, 16);

        $user_data = array(
          'verification_code' => $verification_code,
          // 30 min expiration
          'verification_expiration' => time() + 1800
        );
        $where = array(
          'id' => $user['id']
        );

        // update
        if ($this->user_model->update($user_data, $where)) {
          $send_data = array(
            'expiration' => $user_data['verification_expiration'],
            'code' => $verification_code
          );
          // send email
          $sent = $this->_send_mail($email, 'Password Reset', 'email/password_reset', $send_data);
          // email sent
          if ($sent === TRUE) {
            // go to login
            $this->session->set_flashdata('msg', 'A password reset link was sent to your email.');
            $this->_redirect('login');
            return;
          }
          else {
            $this->session->set_flashdata('msg', 'An error occurred. Unable to send password reset link to email.');
            // debug
            echo $sent;
          }
        }
        // if unable to update
        else {
          $this->session->set_flashdata('msg', 'An error occurred. Unable to update password reset link to email.');
        }
        
      }
      // if user does not exist
      else {
        $this->session->set_flashdata('msg', 'Invalid email. Please try again.');
      }

    }

    // show form
    $form_forgot_data = array();
    $data = array(
      'title' => 'Forgot Password',
      'form_forgot' => $this->load->view('forms/forgot', $form_forgot_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/forgot', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }

  // reset
  public function reset() {
    // if posted
    if ($this->input->post() && $this->session->has_userdata('v_id')) {
      $this->_show_reset_form();
      return;
    }

    if ($code = $this->uri->segment(3)) {
      $this->load->model('user_model');

      // check if code exists in db
      $where = array('verification_code' => $code);
      $user = $this->user_model->fetch($where);

      // return user
      if ($user) {
        $user = $user[0];

        // check if expired
        if (time() < $user['verification_expiration']) {
          // show form
          $this->session->set_userdata(array('v_id' => $user['id']));
          $this->_show_reset_form();
          return;
        }
        // expired
        else {
          $this->session->set_flashdata('msg', 'The verification code has expired.');
        }
      }
      // if user does not exist
      else {
        $this->session->set_flashdata('msg', 'Invalid verification code.');
      }
      
    }
    
    $this->_redirect();
  }

  // reset form
  private function _show_reset_form() {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

    if ($this->form_validation->run() === TRUE) {
      // get id
      if ($id = $this->session->userdata('v_id')) {
        // hash password
        $password = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
        
        $this->load->model('user_model');
        
        // update that id
        $data = array(
          'password' => $password,
          'verification_code' => '',
          'verification_expiration' => ''
        );
        $where = array('id' => $id);
        
        if ($this->user_model->update($data, $where)) {
          // set some msg
          $this->session->set_flashdata('msg', 'Successfully reset password.');
          $this->session->unset_userdata('v_id');
          // go to /
          $this->_redirect();
          return;
        }
        // failed to update
        else {
          $this->session->set_flashdata('msg', 'An error occurred while updating account information.');
        }
      }
      // if id does not exist
      else {
        $this->session->set_flashdata('msg', 'Invalid verification code.');
      }
    }

    // show form
    $form_reset_data = array();
    $data = array(
      'title' => 'Password Reset',
      'form_reset' => $this->load->view('forms/reset', $form_reset_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/reset', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }
  
}

?>