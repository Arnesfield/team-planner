<div>

<div>
  <div>
    <?php if ($memberships[0]['group_image']): ?>
    <img src="<?=base_url('uploads/images/groups/' . $memberships[0]['group_image'])?>"
      style="width: 256px" alt="<?=$memberships[0]['group_image']?>">
    <?php else: ?>
    <div>No profile image</div>
    <?php endif; ?>
  </div>

  <h2><?=$memberships[0]['group_name']?></h2>
  <div>
    <span>
      <?=$memberships[0]['group_desc'] ? $memberships[0]['group_desc'] : 'No description'?>
    </span>
    <?php if ($curr_user_info['member_type'] == 1): ?>
    <span>| 
    <?php
      if ($memberships[0]['group_status'] == 1) echo 'Active';
      else if ($memberships[0]['group_status'] == 2) echo 'Hidden';
      else echo 'Deleted';
    ?>
    </span>
    <span>
      | <a href="<?=base_url('dashboard/groups/' . $group_id . '/manage')?>">Manage group</a>
    </span>
    <?php endif; ?>
  </div>
  
</div>

<!-- add task -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6"><?=$form_create_task?></div>
    <div class="col-md-6">
      <?=$curr_user_info['member_type'] == 1 ? $form_add_members : ''?>
    </div>
  </div>
</div>

<hr>

<?php foreach ($memberships as $key => $member): ?>
<div>

  <div>
    <div>
      <div style="display: inline-block; vertical-align: 100%">
        <img src="<?=base_url('uploads/images/users/' . $member['user_image'])?>" alt="<?=$member['username']?>"
          style="width: 52px;">
      </div>

      <div style="display: inline-block">
        <a href="<?=base_url('dashboard/profile/' . $member['user_id'])?>" target="_blank">
          <h5 style="display: inline-block"><?=$member['username']?></h5>
        </a>
        <div>
          <?=$member['fname'] . ' ' . $member['lname']?>
          | <?=$member['member_type'] == 1 ? 'Admin' : 'Member'?>
        </div>
      </div>

    </div>
  </div>

  <?php if($per_member_tasks[$key]): ?>
  <div>
    <h6>Tasks</h6>

    <div class="container-fluid">
      <!-- row and col -->
      <div class="row">
        <!-- pending tasks -->
        <div class="col-md-3 col-sm-6">
          <div>
            Pending Tasks
          </div>

          <?php
            $i_count = 0;
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 2) {
                echo $task_inst($task);
                $i_count++;
              }
            }
          ?>

          <?php if ($i_count === 0): ?>
          <div>
            No pending tasks.
          </div>
          <?php endif; ?>
        </div>

        <!-- ongoing tasks -->
        <div class="col-md-3 col-sm-6">
          <div>
            Ongoing Tasks
          </div>

          <?php
            $i_count = 0;
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 3) {
                echo $task_inst($task);
                $i_count++;
              }
            }
          ?>

          <?php if ($i_count === 0): ?>
          <div>
            No ongoing tasks.
          </div>
          <?php endif; ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3 col-sm-6">
          <div>
            Done Tasks
          </div>
          <?php
            $i_count = 0;
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 9) {
                echo $task_inst($task);
                $i_count++;
              }
            }
          ?>

          <?php if ($i_count === 0): ?>
          <div>
            No done tasks.
          </div>
          <?php endif; ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3 col-sm-6">
          <div>
            Discontinued Tasks
          </div>
          <?php
            $i_count = 0;
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 8) {
                echo $task_inst($task);
                $i_count++;
              }
            }
          ?>

          <?php if ($i_count === 0): ?>
          <div>
            No discontinued tasks.
          </div>
          <?php endif; ?>
        </div>

      </div>
      <!-- end of row -->

    </div>
    <!-- end of row container -->

  </div>
  <?php else: ?>
  <div>
    <span><strong><?=$member['username']?></strong> has no tasks.</span>
  </div>
  <?php endif; ?>

</div>
<?php endforeach; ?>


</div>