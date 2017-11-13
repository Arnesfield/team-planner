<div>

<!-- add task -->
<div>

<?=$form_create_task?>

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
        <div class="col-md-3">
          <div>
            Pending Tasks
          </div>

          <?php
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 2) echo $task_inst($task);
            }
          ?>
        </div>

        <!-- ongoing tasks -->
        <div class="col-md-3">
          <div>
            Ongoing Tasks
          </div>

          <?php
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 3) echo $task_inst($task);
            }
          ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3">
          <div>
            Done Tasks
          </div>
          <?php
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 9) echo $task_inst($task);
            }
          ?>
        </div>

        <!-- done tasks -->
        <div class="col-md-3">
          <div>
            Discontinued Tasks
          </div>
          <?php
            foreach ($per_member_tasks[$key] as $task_key => $task) {
              if ($task['task_status'] == 8) echo $task_inst($task);
            }
          ?>
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