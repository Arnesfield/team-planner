<div>

<div>
  <h2><?=$memberships[0]['group_name']?></h2>
  <?php if ($curr_user_info['member_type'] == 1): ?>
  <a href="<?=base_url('dashboard/groups/' . $group_id . '/manage')?>">Manage group</a>
  <?php endif; ?>
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
    <h5><?=$member['username']?></h5>
    <div><?=$member['fname'] . ' ' . $member['lname']?></div>
    <div><?=$member['member_type'] == 1 ? 'Admin' : 'Member'?></div>
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