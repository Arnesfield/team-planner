<div class="content">
<div class="pad">

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


<?php foreach ($memberships as $key => $member): ?>
<hr>
<div>

  <div>
    <div>
      <div style="display: inline-block; vertical-align: 100%">
        <img src="<?=base_url('uploads/images/users/' . $member['user_image'])?>" alt="<?=$member['username']?>"
          style="width: 52px;">
      </div>
      &nbsp;
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
      <div class="row n-pad">
        <!-- pending tasks -->
        <div class="col-md-3 col-sm-6">
          <div class="my-p-2" style="background-color: #ccc">
            <i class="material-icons v-mid">pan_tool</i>&nbsp; Pending Tasks
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
          <h6 class="x-pad">No pending tasks.</h6>
          <?php endif; ?>
        </div>

        <!-- ongoing tasks -->
        <div class="col-md-3 col-sm-6">
          <div class="my-p-2 mdl-color--primary mdl-color-text--white">
            <i class="material-icons v-mid">arrow_forward</i>&nbsp; Ongoing Tasks
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
          <h6 class="x-pad">No ongoing tasks.</h6>
          <?php endif; ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3 col-sm-6">
          <div class="my-p-2 mdl-color--accent mdl-color-text--white">
            <i class="material-icons v-mid">done</i>&nbsp; Done Tasks
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
          <h6 class="x-pad">No done tasks.</h6>
          <?php endif; ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3 col-sm-6">
          <div class="my-p-2 mdl-color--red-A200 mdl-color-text--white">
            <i class="material-icons v-mid">close</i>&nbsp; Discontinued Tasks
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
          <h6 class="x-pad">No discontinued tasks.</h6>
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

</div>
</div>