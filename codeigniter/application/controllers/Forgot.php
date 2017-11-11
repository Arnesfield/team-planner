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

  // verify
  public function verify() {
    if ($code = $this->uri->segment(3)) {
      echo $code;
      return;
    }
    
    $this->_redirect();
  }
}

?>