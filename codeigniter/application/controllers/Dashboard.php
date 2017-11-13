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
    if ($group_id = $this->uri->segment(3)) {
      $user_id = $this->session->userdata('user')['id'];

      $this->load->model('membership_model');
      
      // check slug with sess user id and if m status 1
      $where = array(
        // 'm.user_id' => $user_id,
        'm.group_id' => $group_id,
        'm.status' => 1
      );

      $memberships = $this->membership_model->fetch($where);

      if ($memberships) {
        $this->load->model('task_model');

        $per_member_tasks = array();

        foreach ($memberships as $key => $member) {
          $where = array(
            't.group_id' => $group_id,
            't.taken_by_user_id' => $member['user_id'],
            // deleted
            't.status !=' => 0,
          );
          $member_tasks = $this->task_model->fetch($where);
          $per_member_tasks[$key] = $member_tasks;
        }

        $where = array(
          't.group_id' => $group_id,
          't.taken_by_user_id' => 0,
          't.status !=' => 0
        );
        $group_tasks = $this->task_model->fetch($where);




        echo '<pre>';
        print_r($memberships);
        echo '</pre>';

        echo '<pre>';
        print_r($per_member_tasks);
        echo '</pre>';

        echo '<pre>';
        print_r($group_tasks);
        echo '</pre>';

        $data = array(
          'title' => $memberships[0]['group_name'],
          'msg' => $this->session->flashdata('msg'),
          'memberships' => $memberships,
          'per_member_tasks' => $per_member_tasks,
          'group_tasks' => $group_tasks
        );
        $this->_view(
          array('templates/nav', 'pages/dashboard/group_view', 'alerts/msg'),
          array_merge($this->_nav_items, $data)
        );
      }
      // if there are no memberships
      else {
        $this->session->set_flashdata('msg', 'An error occurred. Unable to view group.');
        $this->_redirect('dashboard/groups');
      }
      // show group details
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

    // 1 is owner
    $where['m.type'] = 1;
    $my_groups = $this->membership_model->fetch($where);

    // membership type 2 is normal member
    $where['m.type'] = 2;
    $other_groups = $this->membership_model->fetch($where);

    // can be any type for invited
    unset($where['m.type']);
    $where['m.status'] = 2;
    $invited_groups = $this->membership_model->fetch($where);
    
    $data = array(
      'title' => 'Groups',
      'msg' => $this->session->flashdata('msg'),
      'groups' => $groups,
      'my_groups' => $my_groups,
      'other_groups' => $other_groups,
      'invited_groups' => $invited_groups
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
          // status 2 for invitation
          $membership_data['status'] = 2;
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

  // invites page
  public function invites() {
    $this->load->model('membership_model');
    
    $user_id = $this->session->userdata('user')['id'];

    $where = array(
      'm.user_id' => $user_id,
      'm.status' => 2,
      'g.status' => 1
    );

    $groups = $this->membership_model->fetch($where);
    
    $data = array(
      'title' => 'Group Invitations',
      'msg' => $this->session->flashdata('msg'),
      'groups' => $groups
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/invites', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  public function accept_invite() {
    if (!$this->input->post()) {
      $this->_redirect('dashboard/groups');
      exit();
    }

    if (!isset($this->input->post()['group'])) {
      $this->session->set_flashdata('msg', 'An error occurred while processing group invitation.');
      $this->_redirect('dashboard/groups');
      exit();
    }
    
    if (isset($this->input->post()['accept'])) {
      $flag = 1;
      $this->session->set_flashdata('msg', 'Successfully accepted group invitation.');
    }
    else if (isset($this->input->post()['reject'])) {
      $flag = 0;
      $this->session->set_flashdata('msg', 'Successfully deleted group invitation.');
    }
    
    // modify membership row
    $this->load->model('membership_model');
    
    $group_id = $this->input->post('group', TRUE);
    $user_id = $this->session->userdata('user')['id'];

    $data = array(
      'status' => $flag
    );

    $where = array(
      'user_id' => $user_id,
      'group_id' => $group_id,
      // status should be in invitation mode
      // for it to be updated
      'status' => 2
    );

    if (!$this->membership_model->update($data, $where)) {
      $this->session->set_flashdata('msg', 'An error occurred while processing group invitation.');
    }

    $this->_redirect('dashboard/groups');
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