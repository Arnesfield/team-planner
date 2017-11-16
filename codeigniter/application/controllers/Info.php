<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    // check if session isset
    $this->_if_session_isset();
    $this->_set_info_nav_items();
  }
  
  public function index() {
    $this->load->library('form_validation');

    // check if title belongs in 
    $this->load->model('content_model');
    $where = array('type', 1);
    $contents = $this->content_model->fetch($where);
    $content = $contents ? $contents[0] : array();

    $data = array(
      'title' => $content['title'],
      'form_login' => $this->load->view('forms/login', null, true),
      'msg' => $this->session->flashdata('msg'),
      'content' => $content
    );
    $this->_view(
      array('templates/nav', 'pages/info', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }


  // content
  public function c() {
    // get segment
    // if segment not set, go to home
    if (!$this->uri->segment(3)) {
      $this->_redirect();
      return;
    }

    $title = $this->uri->segment(3);
    // check if title belongs in 
    $this->load->model('content_model');

    $where = array(
      'title' => $title,
      // consider type also
      // 'type' => 2,
      'status' => 1,
    );

    $contents = $this->content_model->fetch($where);

    if (!$contents) {
      $this->session->set_flashdata('msg', 'The page you were looking for does not exist.');
      $this->_redirect();
      return;
    }
    else if ($contents[0]['type'] == 1) {
      $this->_redirect();
      return;
    }

    $content = $contents[0];

    $data = array(
      'title' => $content['title'],
      'msg' => $this->session->flashdata('msg'),
      'content' => $content
    );
    $this->_view(
      array('templates/nav', 'pages/info_sub', 'alerts/msg'),
      array_merge($this->_info_nav_items, $data)
    );
  }

}

?>