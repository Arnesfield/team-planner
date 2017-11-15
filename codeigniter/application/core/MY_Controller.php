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

  protected function _set_nav_items($is_admin = FALSE) {
    // static test
    $admin_navs = array();
    if ($is_admin) {
      $admin_navs = array(
        array(
          'title' => 'Manage Users',
          'href' => 'admin/users'
        ),
        array(
          'title' => 'Manage Groups',
          'href' => 'admin/groups'
        ),
      );
    }

    $navs = array(
      array(
        'title' => 'Home',
        'href' => 'dashboard'
      ),
      array(
        'title' => 'My Profile',
        'href' => 'dashboard/profile'
      ),
      array(
        'title' => 'My Groups',
        'href' => 'dashboard/groups'
      ),
    );

    $end_navs = array(
      array(
        'title' => 'Logout',
        'href' => 'logout'
      )
    );

    $this->_nav_items = array('nav_items' => array_merge($navs, $admin_navs, $end_navs));
  }

  // insert activity log
  protected function _insert_activity($remarks, $type, $date = FALSE) {
    $this->load->model('activity_model');

    $date = $date ? $date : time();

    // types
    // 1 - login
    // 2 - logout
    
    // 3 - created account
    // 4 - verified account
    // 5 - updated account

    // 6 - created group
    // 7 - updated group
    // 8 - updated members in group
    // 9 - changed member info

    // 10 - created task
    // 11 - mark ongoing
    // 12 - mark done
    // 13 - mark discontinued

    // 14 - updated user
    // 15 - updated group

    $data = array(
      'remarks' => $remarks,
      'type' => $type,
      'date' => $date
    );

    return $this->activity_model->insert($data);
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

  // for image upload
  protected function _upload_image($path, $file_name, $p_config = FALSE) {
    
    $config = array(
      'upload_path' => './' . $path,
      'allowed_types' => 'gif|jpg|png',
      'max_size' => 200,
      'max_width' => 1920,
      'max_height' => 1080,
      'file_name' => 'IMG_' . date('dmyHis')
    );

    // override default values
    if ($p_config) {
      foreach ($p_config as $key => $value) {
        $config[$key] = $value;
      }
    }

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload($file_name)) {
      return array(
        'result' => FALSE,
        'return' => $this->upload->display_errors()
      );
    }
    else
    {
      return array(
        'result' => TRUE,
        'return' => $this->upload->data()
      );
    }

  }

}


?>