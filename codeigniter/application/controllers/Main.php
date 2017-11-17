<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_View_Controller {

  public function __construct() {
    parent::__construct();
  }
  
  public function index() {
    $data = array(
      'title' => 'CI Project Setup',
      'code' => 'test',
      'expiration' => time(),
      'email' => 'rylee.jeff385@gmail.com'
    );
    $this->_view(['email/email_verification', 'email/password_reset'], $data, true);
  }
}

?>