<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    
    // redirect to login if not logged in
    if ($this->session->has_userdata('is_logged_in') === FALSE) {
      $this->_redirect('login');
      return;
    }
    
    $user = $this->session->userdata('user');
    // go to dashboard if not admin
    if ($user['type'] != 1) {
      $this->_redirect('dashboard');
      return;
    }
    
    $this->_set_nav_items($user['type'] == 1);
  }
  
  public function index() {
    $this->_redirect('dashboard');
  }

  public function update() {
    if (!$this->input->post()) {
      $this->_redirect('dashboard');
      exit();
    }
    
    // check gid
    if (!($this->input->post('id', TRUE) || $this->input->post('gid', TRUE) || $this->input->post('mid', TRUE))) {
      $this->_redirect('dashboard');
      exit();
    }

    $id = $this->input->post('id', TRUE);
    // if id not set
    // use gid
    if (!$id) {
      $id = $this->input->post('gid', TRUE);
      $g = TRUE;
    }

    // if id not set
    // use mid
    if (!$id) {
      $id = $this->input->post('mid', TRUE);
      $g = FALSE;
      $m = TRUE;
    }

    if (isset($this->input->post()['type'])) {
      $key = 'type';
      $value = $this->input->post('type');
    }
    else if (isset($this->input->post()['status'])) {
      $key = 'status';
      $value = $this->input->post('status');
    }

    if (isset($g) && $g) {
      $this->load->model('group_model');
    }
    else if (isset($m) && $m) {
      $this->load->model('membership_model');
    }
    else {
      $this->load->model('user_model');
    }

    $data[$key] = $value;
    $where = array('id' => $id);

    $user_id = $this->session->userdata('user')['id'];

    if ((isset($g) && $g) && $this->group_model->update($data, $where)) {
      $success = 1;

      $this->_insert_activity('User '.$user_id.' updated Group '.$id.' '.$key.' information.' , 15);
    }
    else if ((isset($m) && $m) && $this->membership_model->update($data, $where)) {
      $success = 1;

      $this->_insert_activity('User '.$user_id.' updated Member '.$id.' '.$key.' information.' , 16);
    }
    else if (!(isset($g) && $g) && !(isset($m) && $m) && $this->user_model->update($data, $where)) {
      $success = 1;

      $this->_insert_activity('User '.$user_id.' updated User '.$id.' '.$key.' information.' , 14);
    }
    else {
      $success = 0;
    }

    echo json_encode(array('success' => $success));
  }

  // users
  public function users() {
    $curr_user_id = $this->session->userdata('user')['id'];

    $this->load->model('combo_model');

    $members = $this->combo_model->fetch_users();
    $members = $members ? $members : array();

    $data = array(
      'title' => 'Manage Users',
      'msg' => $this->session->flashdata('msg'),
      'users' => json_encode($members),
      'curr_user_id' => $curr_user_id,
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/users', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // groups
  public function groups() {
    $this->load->model('combo_model');
    
    $groups = $this->combo_model->fetch_groups();
    $groups = $groups ? $groups : array();

    $data = array(
      'title' => 'Manage Groups',
      'msg' => $this->session->flashdata('msg'),
      'groups' => json_encode($groups),
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/groups', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  public function activities() {
    $this->load->model('combo_model');
    
    $activities = $this->combo_model->fetch_activities();
    $activities = $activities ? $activities : array();

    // foreach activity
    foreach ($activities as $key => $activity) {
      $activities[$key]['raw_date'] = $activity['date'];
      $activities[$key]['date'] = date('l, d M Y H:i:s', $activity['date']);
      $activities[$key]['raw_type'] = $type = $activity['type'];
      switch ($type) {
        case 1: $type = 'Login'; break;
        case 2: $type = 'Logout'; break;

        case 3: $type = 'Created Account'; break;
        case 4: $type = 'Verified Account'; break;
        case 5: $type = 'Updated Account'; break;

        case 6: $type = 'Created Group'; break;
        case 7: $type = 'Updated Group Info'; break;
        case 8: $type = 'Updated Group Members'; break;
        case 9: $type = 'Updated Group Member Info'; break;

        case 10: $type = 'Created Task'; break;
        case 11: $type = 'Mark Task as Ongoing'; break;
        case 12: $type = 'Mark Task as Done'; break;
        case 13: $type = 'Mark Task as Discontinued'; break;

        case 14: $type = 'Admin: Updated User Type/Status'; break;
        case 15: $type = 'Admin: Updated Group Status'; break;
        case 16: $type = 'Admin: Updated Member Type/Status'; break;
        case 17: $type = 'Admin: Updated Content Type/Status'; break;
        case 18: $type = 'Admin: Updated Content Info'; break;

        default: $type = 'Something else'; break;
      }
      
      $activities[$key]['type'] = $type;
    }

    $data = array(
      'title' => 'Manage Activities',
      'msg' => $this->session->flashdata('msg'),
      'activities' => json_encode($activities),
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/activities', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // memberships
  public function memberships() {
    $this->load->model('combo_model');
    
    $memberships = $this->combo_model->fetch_memberships();
    $memberships = $memberships ? $memberships : array();

    $data = array(
      'title' => 'Manage Groups',
      'msg' => $this->session->flashdata('msg'),
      'memberships' => json_encode($memberships),
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/memberships', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // tasks
  public function tasks() {
    $this->load->model('combo_model');
    
    $tasks = $this->combo_model->fetch_tasks();
    $tasks = $tasks ? $tasks : array();

    // foreach task
    foreach ($tasks as $key => $task) {
      
      // set fields of dates
      foreach (array('created_at', 'deadline_at', 'started_at', 'ended_at') as $field) {
        $tasks[$key]['raw_'.$field] = $task[$field];
        // if not 0
        if ($task[$field]) {
          $tasks[$key][$field] = date('l, d M Y H:i:s', $task[$field]);
        }
        // if 0
        else {
          $tasks[$key][$field] = 'TBA';
        }
      }

      $tasks[$key]['raw_status'] = $status = $task['status'];
      switch ($status) {
        case 2: $status = 'Pending'; break;
        case 3: $status = 'Ongoing'; break;
        case 9: $status = 'Done'; break;
        case 8: $status = 'Discontinued'; break;

        default: $status = 'Something else'; break;
      }
      
      $tasks[$key]['status'] = $status;
    }

    $data = array(
      'title' => 'Manage Tasks',
      'msg' => $this->session->flashdata('msg'),
      'tasks' => json_encode($tasks),
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/tasks', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // content
  public function content() {
    $this->load->model('content_model');
    
    $contents = $this->content_model->fetch(array());
    $contents = $contents ? $contents : array();

    $data = array(
      'title' => 'Manage Content',
      'msg' => $this->session->flashdata('msg'),
      'contents' => json_encode($contents),
      '_do_bootstrap' => TRUE,
    );
    $this->_view(
      array('templates/nav', 'pages/admin/contents', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // update content
  public function content_update() {
    if (!$this->input->post()) {
      $this->_redirect('dashboard');
      exit();
    }

    $this->load->model('content_model');

    $action = $this->input->post('action', TRUE);
    $user_id = $this->session->userdata('user')['id'];
    $success = 0;
    if ($action == 'status') {
      $cid = $this->input->post('cid', TRUE);
      $status = $this->input->post('status', TRUE);

      $data = array('status' => $status);
      $where = array('id' => $cid);

      $this->content_model->update($data, $where);

      $this->_insert_activity('User '.$user_id.' updated Content '.$cid.' status information.' , 17);
      
      $success = 1;
    }
    else if ($action == 'type') {
      $to = $this->input->post('to', TRUE);
      $from = $this->input->post('from', TRUE);
      
      $data = array('type' => $to['type']);
      $where = array('id' => $to['cid']);

      $this->content_model->update($data, $where);

      $this->_insert_activity('User '.$user_id.' updated Content '.$to['cid'].' type information.' , 17);
      
      $data = array('type' => $from['type']);
      $where = array('id' => $from['cid']);
      
      $this->content_model->update($data, $where);

      $this->_insert_activity('User '.$user_id.' updated Content '.$from['cid'].' type information.' , 17);
      
      $success = 1;
    }
    else if ($action == 'submit') {
      $contents = $this->input->post('contents');
      
      foreach ($contents as $key => $content) {
        // only need id, title, and content
        $id = $content['id'];
        $title = $content['title'];
        $type = $content['type'];
        $status = $content['status'];
        $cont = $content['content'];

        $data = array(
          'title' => $title,
          'content' => $cont,
        );
        $where = array('id' => $id);

        // fetch if exists
        // if not, insert

        $fetched = $this->content_model->fetch($where);

        if ($fetched) {
          $fetched = $fetched[0];
          // update if did not change
          if (!($title == $fetched['title'] && $cont == $fetched['content']) && $title) {
            // update
            $this->content_model->update($data, $where);
            
            $this->_insert_activity('User '.$user_id.' updated Content '.$id.' information.' , 18);
          }
        
          $success = 1;
          $this->session->set_flashdata('msg', 'Successfully updated content.');
        }
        // insert
        else {
          $data['type'] = $type;
          $data['status'] = $status;
          
          if ($title && $this->content_model->insert($data)) {

            $fetched = $this->content_model->fetch($data)[0];
            
            $this->_insert_activity('User '.$user_id.' added Content '.$fetched['id'].' information.' , 18);
            
          }
          
          $success = 1;
          $this->session->set_flashdata('msg', 'Successfully updated content.');
        }
      }

    }

    echo json_encode(array('success' => $success));
  }

}

?>