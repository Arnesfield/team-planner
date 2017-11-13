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
    $this->load->library('form_validation');

    // if create task
    if ($this->input->post() && $this->session->has_userdata('curr_group_id')) {
      $g_id = $this->session->userdata('curr_group_id');
      $user_id = $this->session->userdata('user')['id'];

      $this->load->model('task_model');
      $this->load->model('membership_model');

      // set rules here
      if ($this->input->post('action') == 'create') {
        // task rules
        $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('desc', 'Description', 'trim');
        $this->form_validation->set_rules('assign', 'Member', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        
        if ($this->form_validation->run() === TRUE) {
          $name = strip_tags($this->input->post('name'));
          $desc = strip_tags($this->input->post('desc'));
          $assign = strip_tags($this->input->post('assign'));
          $date = strip_tags($this->input->post('date'));
          $time = strip_tags($this->input->post('time'));
  
          $deadline = strtotime($date . ' ' . $time);

          // check if $assign is included in group
          $where = array(
            'm.group_id' => $g_id,
            'm.user_id' => $assign,
            'm.status' => 1
          );

          if ($this->membership_model->fetch($where)) {
            $t_data = array(
              'name' => $name,
              'description' => $desc,
              'group_id' => $g_id,
              'created_by_user_id' => $user_id,
              'taken_by_user_id' => $assign,
              'created_at' => time(),
              'deadline_at' => $deadline,
              'started_at' => 0,
              'ended_at' => 0,
              'status' => 2
            );
  
            // deadline should be greater than now
            $is_valid_date = $deadline > time();
  
            // insert
            if ($is_valid_date && $this->task_model->insert($t_data)) {
              $this->session->set_flashdata('msg', 'Successfully added task!');
            }
            else {
              if ($is_valid_date) {
                $this->session->set_flashdata('msg', 'Unable to create task. Please try again.');
              }
              else {
                $this->session->set_flashdata('msg', 'Unable to create task with a deadline in the past.');
              }
            }
          }
          // if not included in group
          else {
            $this->session->set_flashdata('msg', 'Unable to create task. Please try again.');
          }

        }
        // error occurred
        else {
          $this->session->set_flashdata('msg', 'Unable to create task. Please try again.');
        }

      }
      // end of action create
      else if ($this->input->post('action') == 'mark') {
        if (isset($this->input->post()['start'])) {
          // move task to ongoing
          // status 3
          $stat = 3;
        }
        else if (isset($this->input->post()['done'])) {
          // move task to done
          // status 9
          $stat = 9;
        }
        else if (isset($this->input->post()['remove'])) {
          // move task to discontinued
          // status 8
          $stat = 8;
        }
        // if none
        else {

        }

        if (isset($stat) && $this->input->post('t_id', TRUE)) {
          $t_id = $this->input->post('t_id', TRUE);
          // update
          $t_data = array(
            'status' => $stat
          );

          $t_where = array(
            'id' => $t_id,
            'group_id' => $g_id,
            'taken_by_user_id' => $user_id
          );

          // ongoing
          if ($stat == 3) {
            $t_data['started_at'] = time();
          }
          // done or discontinued
          else if ($stat == 9 || $stat == 8) {
            $t_data['ended_at'] = time();
          }

          if ($this->task_model->update($t_data, $t_where)) {
            $this->session->set_flashdata('msg', 'Successfully updated task.');
          }
          // update failed
          else {
            $this->session->set_flashdata('msg', 'An error occurred. Unable to update task.');
          }

        }
      }
      // end of action mark

      $this->_redirect('dashboard/groups/' . $g_id);
      return;
    }

    if ($group_id = $this->uri->segment(3)) {
      // set group id to session
      $this->session->set_userdata('curr_group_id', $group_id);

      $user_id = $this->session->userdata('user')['id'];

      $this->load->model('membership_model');
      
      // check g id with sess user id and if m status 1
      $where = array(
        'm.user_id' => $user_id,
        'm.group_id' => $group_id,
        'm.status' => 1
      );

      $my_membership = $this->membership_model->fetch($where);

      if ($my_membership) {
        $this->load->model('task_model');
        $this->load->model('user_model');

        $per_member_tasks = array();
        $curr_user_info = array();

        $where = array(
          // 'm.user_id' => $user_id,
          'm.group_id' => $group_id,
          'm.status' => 1
        );
  
        $memberships = $this->membership_model->fetch($where);

        foreach ($memberships as $key => $member) {
          $where = array(
            't.group_id' => $group_id,
            't.taken_by_user_id' => $member['user_id'],
            // deleted
            't.status !=' => 0,
          );
          $member_tasks = $this->task_model->fetch($where);
          $per_member_tasks[$key] = $member_tasks;

          // save info of curr user
          if ($user_id == $member['user_id']) {
            $curr_user_info = $member;
          }
        }

        $where = array(
          't.group_id' => $group_id,
          't.taken_by_user_id' => 0,
          't.status !=' => 0
        );
        $group_tasks = $this->task_model->fetch($where);

        $form_create_task_data = array(
          'sess_user_id' => $user_id,
          'members' => $memberships
        );
        
        $form_add_members_data = array();
        
        $data = array(
          'sess_user_id' => $user_id,
          'curr_user_info' => $curr_user_info,
          'title' => $memberships[0]['group_name'],
          'msg' => $this->session->flashdata('msg'),
          'memberships' => $memberships,
          'per_member_tasks' => $per_member_tasks,
          'group_tasks' => $group_tasks,
          'form_create_task' => $this->load->view('forms/create_task', $form_create_task_data, TRUE),
          'form_add_members' => $this->load->view('forms/add_members', $form_add_members_data, TRUE),
          'task_inst' => function($task) {
            $view_data = array(
              'sess_user_id' => $this->session->userdata('user')['id'],
              'task' => $task,
              'get_creator' => function($id) {
                $where = array('id' => $id);
                return $this->user_model->fetch($where)[0]['username'];
              },
            );
            return $this->load->view('forms/task_inst', $view_data, TRUE);
          }
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
    // unset sess group id
    $this->session->unset_userdata('curr_group_id');

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

        // create memberships based on number of users[]
        if ($users = $this->input->post('users')) {
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

    $owners = array();
    $groups = $this->membership_model->fetch($where);
    // fetch owners of groups
    foreach ($groups as $key => $group) {
      $o_where = array(
        'm.type' => 1,
        'g.id' => $group['group_id'],
        'g.status' => 1
      );
      $owners[$key] = $this->membership_model->fetch($o_where);
    }
    
    $data = array(
      'title' => 'Group Invitations',
      'msg' => $this->session->flashdata('msg'),
      'groups' => $groups,
      'owners' => $owners
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


  public function add_members() {
    // check if post and curr group id exists
    // check if a user + group id exists in membership
    // update that if exists
    // else, add
    // redirect to group id

    if (!($this->input->post() || $this->session->has_userdata('curr_group_id'))) {
      $this->_redirect('dashboard/groups');
      exit();
    }

    $curr_group_id = $this->session->userdata('curr_group_id');
    $user_id = $this->session->userdata('user')['id'];
    
    $this->load->model('membership_model');
    
    if ($users = $this->input->post('users')) {
      foreach ($users as $user) {
        $where = array(
          'm.user_id' => $user['id'],
          'm.group_id' => $curr_group_id
        );
        
        // if membership exists, update
        // else, insert
        if ($membership = $this->membership_model->fetch($where)) {
          $m_id = $membership[0]['membership_id'];

          $m_data = array(
            'type' => 2,
            'status' => 2
          );

          $m_where = array(
            'id' => $m_id
          );

          if ($this->membership_model->update($m_data, $m_where)) {
            $this->session->set_flashdata('msg', 'Successfully sent group invitation.');
          }
          // failed updated
          else {
            $this->session->set_flashdata('msg', 'An error occurred while processing group invitation.');
          }
        }
        // insert
        else {
          $data = array(
            'user_id' => $user['id'],
            'group_id' => $curr_group_id,
            'type' => 2,
            // invitation
            'status' => 2
          );

          if ($this->membership_model->insert($data)) {
            $this->session->set_flashdata('msg', 'Successfully sent group invitation.');
          }
          // failed insert
          else {
            $this->session->set_flashdata('msg', 'An error occurred while processing group invitation.');
          }

        }
        
      }
    }

    $this->_redirect('dashboard/groups/' . $curr_group_id);
  }


  // json
  public function users_json() {
    if (!$this->input->post()) {
      $this->_redirect();
      exit();
    }

    if ($text = strip_tags($this->input->post('text'))) {
      $curr_user_id = $this->session->userdata('user')['id'];
      $ids = array();
      array_push($ids, $curr_user_id);

      if ($this->session->has_userdata('curr_group_id')) {
        $this->load->model('membership_model');

        $g_id = $this->session->userdata('curr_group_id');

        $where = array(
          'm.group_id' => $g_id,
          'm.status' => 1
        );
  
        // get members of curr sess group id
        $members = $this->membership_model->fetch($where);
        foreach ($members as $key => $member) {
          array_push($ids, $member['user_id']);
        }
      }

      // search users using text
      $this->load->model('user_model');

      $users = $this->user_model->fetch_like($text, $ids);

      if ($users) {
        echo json_encode($users);
      }
    }
  }
}

?>