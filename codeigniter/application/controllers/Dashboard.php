<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->_set_nav_items();
    $this->load->library('session');

    $user = $this->session->userdata('user');

    // redirect to login if not logged in
    if ($this->session->has_userdata('is_logged_in') === FALSE) {
      $this->_redirect('login');
    }
  }
  
  // use index for notifications and such
  public function index() {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    $data = array(
      'title' => 'Dashboard',
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/dashboard', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // groups page
  public function groups() {
    if ($group_code = $this->uri->segment(3)) {
      return;
    }

    // if group code segment does not exist
    $this->_show_list_of_groups();
  }

  // show list of groups
  private function _show_list_of_groups() {
    // show groups of current user
    // create group button
    $this->load->model('membership_model');
    
    $user_id = $this->session->userdata('user')['id'];

    $where = array(
      'm.user_id' => $user_id,
      'm.status' => 1,
      'g.status' => 1
    );

    $groups = $this->membership_model->fetch($where);
    
    $data = array(
      'title' => 'Groups',
      'msg' => $this->session->flashdata('msg'),
      'groups' => $groups
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/groups', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // create group
  public function create() {
    // form validation
    $this->load->library('form_validation');

    $this->form_validation->set_rules('name', 'Group Name', 'trim|required');
    $this->form_validation->set_rules('desc', 'Description', 'trim');

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('group_model');
      
      $name = strip_tags($this->input->post('name'));
      $desc = strip_tags($this->input->post('desc'));
      $slug = $this->group_model->_create_slug($this->group_model->_tbl, 'slug', $name);
      
      // insert 1 group
      $data = array(
        'name' => $name,
        'description' => $desc,
        'slug' => $slug,
        'status' => 1
      );
      
      if ($this->group_model->insert($data)) {
        // create memberships based on number of users[]
        if ($users = $this->input->post('users')) {
          $this->load->model('membership_model');
          // fetch group id using $slug
          $group = $this->group_model->fetch($data)[0];
          
          $membership_data = array(
            'user_id' => $this->session->userdata('user')['id'],
            'group_id' => $group['id'],
            'type' => 1,
            'status' => 1
          );

          // insert yourself
          $this->membership_model->insert($membership_data);
          
          // insert others
          $membership_data['type'] = 2;
          foreach ($users as $user) {
            $membership_data['user_id'] = $user['id'];
            $this->membership_model->insert($membership_data);
          }

        }
        // no users set
        // debug
        else {
          print_r($this->input->post('users'));
        }

        $this->session->set_flashdata('msg', 'Successfully created group!');
        $this->_redirect('dashboard/groups');
        return;
      }
      // if error
      else {
        $this->session->set_flashdata('msg', 'An error occurred. Unable to create group.');
      }
    }

    $form_create_data = array('curr_user_id' => $this->session->userdata('user')['id']);
    $data = array(
      'title' => 'Create Group',
      'form_create' => $this->load->view('forms/create_group', $form_create_data, true),
      'msg' => $this->session->flashdata('msg')
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/create_group', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }


  // json
  public function users_json() {
    if (!$this->input->post()) {
      $this->_redirect();
      exit();
    }

    if ($text = $this->input->post('text')) {
      $curr_user_id = $this->session->userdata('user')['id'];
      // search users using text
      $this->load->model('user_model');

      $users = $this->user_model->fetch_like($text, $curr_user_id);

      if ($users) {
        echo json_encode($users);
      }
    }
  }
}

?>