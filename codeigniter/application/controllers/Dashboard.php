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
      'msg' => $this->session->flashdata('msg'),
      'user' => $this->_fetch_user()
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/dashboard', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  public function profile() {
    // if posted and sess curr edit id is set
    if ($this->input->post() && $this->session->has_userdata('curr_user_id_edit')) {
      $this->_edit_profile();
      return;
    }

    // else, continue here

    $user_id = $this->session->userdata('user')['id'];
    // if third segment is not specified
    if (!$this->uri->segment(3)) {
      $this->_redirect('dashboard/profile/' . $user_id);
      return;
    }

    $id_segment = $this->uri->segment(3);
    // user should be active!
    $user = $this->_fetch_user($id_segment);

    // if user does not exist
    // or user status is 0
    if (!$user || $user['status'] == 0) {
      $this->session->set_flashdata('msg', 'An error occurred. User does not exist.');
      $this->_redirect('dashboard');
      return;
    }

    // allow edit if curr id == segment
    $allow_edit = $id_segment === $user_id;

    if ($allow_edit && $this->uri->segment(4) === 'edit') {
      $edit = true;
    }
    // if not edit, redirect to no /edit
    else if ($this->uri->segment(4) === 'edit') {
      $this->_redirect('dashboard/profile/' . $id_segment);
      return;
    }
    // else if any segment
    // go back to profile
    else if ($this->uri->segment(4)) {
      $this->_redirect('dashboard/profile/' . $id_segment);
      return;
    }

    // if just view
    if (!(isset($edit) && $edit)) {
      // unset user id edit here
      $this->session->unset_userdata('curr_user_id_edit');
      // display profile view
      $data = array(
        'title' => 'My Profile',
        'msg' => $this->session->flashdata('msg'),
        'user' => $user,
        'allow_edit' => $allow_edit
      );
      $this->_view(
        array('templates/nav', 'pages/dashboard/profile', 'alerts/msg'),
        array_merge($this->_nav_items, $data)
      );
      return;
    }

    // proceed here if edit
    $this->load->library('form_validation');

    // set session of currently editing
    // unset if not editing above
    $this->session->set_userdata('curr_user_id_edit', $user['id']);
    // display edit profile view
    $this->_show_edit_profile($user);
  }

  // show edit profile
  private function _show_edit_profile($user) {
    $form_edit_profile_data = array(
      'user' => $user,
      'write_val' => function($key, $u) {
        return set_value($key) ? set_value($key) : $u[$key];
      }
    );
    $data = array(
      'title' => 'Edit Profile',
      'msg' => $this->session->flashdata('msg'),
      'form_edit_profile' => $this->load->view('forms/edit_profile', $form_edit_profile_data, TRUE)
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/edit_profile', 'alerts/msg'),
      array_merge($this->_nav_items, $data)
    );
  }

  // get user info by default
  private function _fetch_user($id = FALSE) {
    // fetch data of user
    $this->load->model('user_model');
    $user_id = $id === FALSE ? $this->session->userdata('user')['id'] : $id;
    $where = array('id' => $user_id);
    $user = $this->user_model->fetch($where);
    return $user ? $user[0] : FALSE;
  }
  
  // edit profile
  private function _edit_profile() {
    $user_id = $this->session->userdata('user')['id'];
    $edit_id = $this->session->userdata('curr_user_id_edit');
    
    // edit id should be the same as curr user session id
    // otherwise, return
    if ($user_id !== $edit_id) {
      $this->_redirect('dashboard/profile/' . $edit_id);
      return;
    }
    
    // do edit here
    $this->load->library('form_validation');
    $this->load->database();

    $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[3]|max_length[16]|callback__is_different[users.username]');
    $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
    $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback__is_different[users.email]');
    $this->form_validation->set_rules('bio', 'Bio', 'trim');
    // not required password
    $this->form_validation->set_rules('old_password', 'Password', 'trim|callback__is_pass_match');
    $this->form_validation->set_rules('password', 'Password', 'trim|custom_match[passconf]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|custom_match[password]');
    
    $user = $this->_fetch_user($user_id);

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('user_model');

      // compare set email to curr email
      // if changed, send new confirmation and make status 2 lol
      $username = strip_tags($this->input->post('username'));
      $fname = strip_tags($this->input->post('fname'));
      $lname = strip_tags($this->input->post('lname'));
      $email = strip_tags($this->input->post('email'));
      $bio = strip_tags($this->input->post('bio'));
      $bio = $bio ? $bio : '';

      // update values
      $data = array(
        'username' => $username,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'bio' => $bio,
        'reset_expiration' => 0
      );
      $where = array('id' => $user_id);

      if (
        ($new_password = strip_tags($this->input->post('password')))
        && ($old_password = strip_tags($this->input->post('old_password')))
      ) {
        if ($is_valid_oldpass = password_verify($old_password, $user['password'])) {
          $new_password = password_hash($new_password, PASSWORD_DEFAULT);

          $data['password'] = $new_password;
        }
      }

      // compare email
      if ($user['email'] !== $email) {
        // send email for confirmation
        // set status to 2
        $verification_code = $this->_generate_code();
        
        // send email verification code
        $send_data = array('code' => $verification_code);
        // send email
        $sent = $this->_send_mail($email, 'Email Verification', 'email/email_verification', $send_data);
        // if sent
        if ($sent === TRUE) {
          $data['verification_code'] = $verification_code;
          $data['status'] = 2;
          $data['email'] = $email;
          $email_ok = true;
        }
        // if not sent
        else {
          $email_error = true;
        }
        
      }
      
      // update
      if ($this->user_model->update($data, $where)) {
        if (isset($email_error) && $email_error) {
          $this->session->set_flashdata('msg', 'Updated profile but unable to change email.');
        }
        else if (isset($email_ok) && $email_ok) {
          // logout lol
          $this->_unset_session_but('msg');
          $this->session->set_flashdata('msg', 'Updated profile. An email verification was sent. Confirm before login.');
          $this->_redirect();
          return;
        }
        else {
          $this->session->set_flashdata('msg', 'Updated profile.');
        }
      }
      // failed update
      else {
        $this->session->set_flashdata('msg', 'An error occurred while updating user profile.');
      }

      // redirect
      $this->_redirect('dashboard/profile/' . $user_id);
      return;
    }

    $this->_show_edit_profile($user);
  }

  // callback for checking email and username
  public function _is_different($str, $field) {
    $user_id = $this->session->userdata('user')['id'];

    // based on is_unique[]
		sscanf($field, '%[^.].%[^.]', $table, $field);
		$res = isset($this->db)
			? ($this->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $user_id))->num_rows() === 0)
      : FALSE;
      
    if (!$res) {
      $this->form_validation->set_message('_is_different', 'This {field} is already taken.');
    }
    
    return $res;
  }
  
  // callback for password
  public function _is_pass_match($password) {
    if (empty($password)) {
      return TRUE;
    }

    $user_id = $this->session->userdata('user')['id'];
    $user = $this->_fetch_user($user_id);

    if (password_verify($password, $user['password'])) {
      return TRUE;
    }

    $this->form_validation->set_message('_is_pass_match', '{field} is incorrect.');
    return FALSE;
  }

  // manage view
  private function _manage_group($manage, $my_membership) {
    $group_id = $this->session->userdata('curr_group_id');
    
    if (!$group_id) {
      $this->session->set_flashdata('msg', 'An error occurred. Unable to view group settings.');
      $this->_redirect('dashboard/groups');
      return;
    }

    // if 4th segment exists but not manage
    $error = $manage != 'manage';
    $error = $error ? $error : $my_membership['member_type'] != 1;
    
    if ($error) {
      $this->session->set_flashdata('msg', 'An error occurred. Unable to view group settings.');
      $this->_redirect('dashboard/groups/' . $group_id);
      return;
    }

    // fetch group info using $group_id
    $this->load->model('group_model');

    $where = array(
      'id' => $group_id
    );

    $group_infos = $this->group_model->fetch($where);

    // display view for manage
    $form_manage_group_data = array(
      'group_id' => $group_id,
      'group_info' => $group_infos[0]
    );
    $manage_data = array(
      'title' => 'Manage Group',
      'msg' => $this->session->flashdata('msg'),
      'form_manage_group' => $this->load->view('forms/manage_group', $form_manage_group_data, TRUE)
    );
    $this->_view(
      array('templates/nav', 'pages/dashboard/manage_group', 'alerts/msg'),
      array_merge($this->_nav_items, $manage_data)
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
      else if ($this->input->post('action') == 'manage' && $this->uri->segment(4) == 'manage') {
        // update stuff here
        $this->form_validation->set_rules('name', 'Group Name', 'trim|required');
        $this->form_validation->set_rules('desc', 'Description', 'trim');

        if ($this->form_validation->run() === TRUE) {
          $this->load->model('group_model');
          $this->load->model('membership_model');
          
          $name = strip_tags($this->input->post('name'));
          $desc = strip_tags($this->input->post('desc'));
          $users = $this->input->post('users');
          $status = $this->input->post('status', TRUE);
          $status = $status == 'on' ? 1 : 2;
          
          // update 1 group
          $data = array(
            'name' => $name,
            'description' => $desc,
            'status' => $status
          );

          $where = array(
            'id' => $g_id
          );

          if ($this->group_model->update($data, $where)) {
            // update members
            // don't update if js is disabled
            if (isset($this->input->post()['isjs'])) {

              // note that users[] does not include
              // the current user, so add that too
              $users = $this->input->post('users') ? $this->input->post('users') : array();
              array_push($users, $user_id);
              // fetch all membership rows with uid and gid
              // if not equal with $users, set status to 0
              $where_in = array(
                // 'col' => 'm.user_id',
                // 'data' => $users
              );
              $where = array(
                'group_id' => $g_id
              );
              if ($fetched_all = $this->membership_model->fetch($where, $where_in)) {
                // loop through fetch all and update that row's status to 0
                // if user_id field not in $users
                foreach ($fetched_all as $fetched) {
                  $m_where = array('id' => $fetched['membership_id']);

                  // if included, update status
                  if (in_array($fetched['user_id'], $users)) {
                    // status 2 for invitation
                    $m_data = array('status' => 2);
                    // do not include if already in group || status 1
                    // can also be status = 0 but whatever
                    $m_where['status !='] = 1;
                  }
                  // if not, remove from group
                  else {
                    $m_data = array('status' => 0);
                    // do not include if already 0
                    $m_where['status !='] = 0;
                  }

                  $this->membership_model->update($m_data, $m_where);
                }
              }

              // add users
              // note that the above code pertains to
              // users who have record of being in the group
              // add users either add or update
              $this->_add_users($users);
            }

            $this->session->set_flashdata('msg', 'Successfully updated group information.');
          }
          // failed update
          else {
            $this->session->set_flashdata('msg', 'An error occurred. Unable to update group information.');
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
        'm.status' => 1,
        // group should be active to view
        // 'g.status' => 1
      );

      $my_membership = $this->membership_model->fetch($where);
      // if did exists, check status of group and member type
      $temp = $my_membership[0];
      
      // if group status is 0, don't
      if ($temp['group_status'] == 0) {
        $my_membership = FALSE;
      }
      // if group is not active
      else if ($temp['group_status'] != 1) {
        // check if member is admin
        // if admin, allow
        if ($temp['member_type'] != 1) {
          $my_membership = FALSE;
        }
      }

      if ($my_membership) {
        $this->load->model('task_model');
        $this->load->model('user_model');

        // check for segment for 'manage' here
        if ($manage = $this->uri->segment(4)) {
          $this->_manage_group($manage, $my_membership[0]);
          return;
        }

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
          'group_id' => $group_id,
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
        $this->session->unset_userdata('curr_group_id');
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
    // allow status 2 for my groups for hidden
    // 0 is deleted
    unset($where['g.status']);
    $where['g.status !='] = 0;
    $my_groups = $this->membership_model->fetch($where);
    
    // membership type 2 is normal member
    $where['m.type'] = 2;
    $where['g.status'] = 1;
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
      
      // insert 1 group
      $data = array(
        'name' => $name,
        'description' => $desc,
        'status' => 1
      );
      
      if ($this->group_model->insert($data)) {
        $this->load->model('membership_model');
        // fetch group id using $data
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
    
    if ($users = $this->input->post('users')) {
      $this->_add_users($users);
    }

    $this->_redirect('dashboard/groups/' . $curr_group_id);
  }


  private function _add_users($users) {
    $curr_group_id = $this->session->userdata('curr_group_id');
    $user_id = $this->session->userdata('user')['id'];
    
    $this->load->model('membership_model');

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
          // reuse member type
          // to not rewrite current type
          'type' => $membership[0]['member_type'],
          'status' => 2
        );

        $m_where = array(
          'id' => $m_id,
          // status should be 0 to invite
          'status' => 0
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

  // json
  public function users_json() {
    if (!$this->input->post()) {
      $this->_redirect();
      exit();
    }

    if (($update = isset($this->input->post()['update'])) || $text = strip_tags($this->input->post('text'))) {
      $text = isset($text) ? $text : strip_tags($this->input->post('text'));

      $curr_user_id = $this->session->userdata('user')['id'];
      $ids = array();
      $not_id = FALSE;
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
        // remove current user from ids
        $not_id = array($curr_user_id);
      }

      // search users using text
      $this->load->model('user_model');

      $users = $this->user_model->fetch_like($update ? '' : $text, $ids, $update, $not_id);

      if ($users) {
        echo json_encode($users);
      }
    }

  }


  // delete group
  public function delete_group() {
    if (!$this->input->post()) {
      $this->_redirect();
      exit();
    }

    if (($password = $this->input->post('password')) && $group_id_post = $this->input->post('delete')) {
      $this->load->model('user_model');
      $user_id = $this->session->userdata('user')['id'];
      // fetch user
      $where = array('id' => $user_id);
      $user = $this->user_model->fetch($where);

      // verify if user is valid
      if ($user && password_verify($password, $user[0]['password'])) {
        // compare group ids
        if ($this->session->userdata('curr_group_id') == $group_id_post) {
          // change status of group id to 0
          $this->load->model('group_model');

          $data = array(
            'status' => 0
          );
          $where = array(
            'id' => $group_id_post
          );

          if ($this->group_model->update($data, $where)) {
            $this->session->set_flashdata('msg', 'Successfully deleted group.');
            echo json_encode(array(
              'success' => 1,
              'message' => 'Successfully deleted group.'
            ));
          }
          // failed to update
          else {
            echo json_encode(array(
              'success' => 0,
              'message' => 'Unable to delete group.'
            ));
          }
        }
        // if not match
        else {
          echo json_encode(array(
            'success' => 0,
            'message' => 'Invalid group session.'
          ));
        }
      }
      // show error message
      else {
        echo json_encode(array(
          'success' => 0,
          'message' => 'Invalid password.'
        ));
      }

    }

  }

}

?>