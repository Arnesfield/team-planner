<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
  public function __construct() {
    parent::__construct();
  }
}

/**
 * View Controller
 * 
 * Extend to this controller to load views.
 */
class MY_View_Controller extends MY_Controller {
  
  /**
   * Loads URL helper.
   */
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
  }

  /**
   * Loads a view in the views/ directory.
   *
   * @param mixed $view Name of the view or an array of names of the views in views/ to be loaded
   * @param mixed $data A string title for the view or an associative array to be passed in the $view
   * @param boolean $view_only Loads the $view only; otherwise, header and footer in views/templates/ are also loaded
   * @return void
   */
  protected function _view($view = 'pages/home', $data = array(), $view_only = FALSE) {
    $header = 'templates/header';
    $footer = 'templates/footer';

    // create array of views
    $views = array();

    // add header
    if (!$view_only) {
      array_push($views, $header);
    }

    // turn $view into array
    if (!is_array($title = $view)) {
      $view = array($view);
    }
    // add $view
    $views = array_merge($views, $view);

    // add footer
    if (!$view_only) {
      array_push($views, $footer);
    }

    // turn $data into array with title
    if (is_string($data)) {
      $data = array('title' => $data);
    }

    // set title if data is null or empty
    if (empty($data) && is_string($title)) {
      $data['title'] = ucfirst(basename($title));
    }

    // load $views
    foreach ($views as $index => $view) {
      // check if page exists
      if (!file_exists(APPPATH . 'views/' . $view . '.php')) {
        show_404();
      }
      // load view
      $this->load->view($view, $index === 0 ? $data : NULL);
    }

  }
}


// custom controller
class MY_Custom_Controller extends MY_View_Controller {
  public function __construct() {
    parent::__construct();
    // $this->_set_info_nav_items();
    // $this->_set_nav_items();
  }

  protected function _set_info_nav_items() {
    // static test
    $this->_info_nav_items = array('nav_items' => array(
      array(
        'title' => 'Home',
        'href' => ''
      )
    ));
  }

  protected function _set_nav_items() {
    // static test
    $this->_nav_items = array('nav_items' => array(
      array(
        'title' => 'Home',
        'href' => 'dashboard'
      ),
      array(
        'title' => 'My Profile',
        'href' => 'dashboard/profile'
      ),
      array(
        'title' => 'Groups',
        'href' => 'dashboard/groups'
      ),
      array(
        'title' => 'Logout',
        'href' => 'logout'
      )
    ));
  }

  protected function _redirect($to = '') {
    redirect(base_url($to));
  }

  protected function _unset_session_but($except) {
    // unset userdata except $except
    foreach ($this->session->userdata() as $key => $value) {
      if ($key !== $except) {
        $this->session->unset_userdata($key);
      }
    }
  }

  protected function _if_session_isset() {
    // redirect to dashboard if logged in
    if ($this->session->has_userdata('is_logged_in') === TRUE) {
      $this->_redirect('dashboard');
    }
  }

  // send email
  private $_EMAIL = 'mail.arnesfield@gmail.com';

  protected function _send_mail($to, $subject, $view, $data, $from_name = 'Team-Planner Project Team') {
    $this->load->library('email');
    
    // true on third param on view
    $this->email->from($this->_EMAIL, $from_name);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($this->load->view($view, $data, TRUE));
    
    if ($this->email->send()) {
      return TRUE;
    }
    else {
      return $this->email->print_debugger();
    }
  }

  protected function _generate_code() {
    return substr(md5(uniqid(rand(), true)), -16, 16);
  }

}


?>