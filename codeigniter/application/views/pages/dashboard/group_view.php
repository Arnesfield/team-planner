<div>

<?php foreach ($memberships as $key => $member): ?>
<div>

  <div>
    <h5><?=$member['username']?></h5>
    <span><?=$member['fname'] . ' ' . $member['lname']?></span>
  </div>

  <?php if($per_member_tasks[$key]): ?>
  <div>
    <h6>Tasks</h6>

    <div>
      <!-- row and col -->
      <div>
        <!-- ongoing tasks -->
        <div>
          <div>
            Ongoing Tasks
          </div>

          <?php foreach ($per_member_tasks[$key] as $task_key => $task): ?>
            <?php if (!($task['status'] == 8 || $task['status'] == 9)): ?>
            <div>
              <h6><?=task['task_name']?></h6>
              <div><?=task['task_desc']?></div>
              <div><?=date('l, d F Y H:i:s', task['task_started_at'])?></div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- done tasks -->
        <div>
          <div>
            Done Tasks
          </div>
          <?php foreach ($per_member_tasks[$key] as $task_key => $task): ?>
            <?php if ($task['status'] == 9): ?>
            <div>
              <h6><?=task['task_name']?></h6>
              <div><?=task['task_desc']?></div>
              <div><?=date('l, d F Y H:i:s', task['task_started_at'])?></div>
              <div><?=date('l, d F Y H:i:s', task['task_ended_at'])?></div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <!-- done tasks -->
        <div>
          <div>
            Discontinued Tasks
          </div>
          <?php foreach ($per_member_tasks[$key] as $task_key => $task): ?>
            <?php if ($task['status'] == 8): ?>
            <div>
              <h6><?=task['task_name']?></h6>
              <div><?=task['task_desc']?></div>
              <div><?=date('l, d F Y H:i:s', task['task_started_at'])?></div>
              <div><?=date('l, d F Y H:i:s', task['task_ended_at'])?></div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
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