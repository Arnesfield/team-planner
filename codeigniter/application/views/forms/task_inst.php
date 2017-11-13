<div>
  <h6><?=$task['task_name']?></h6>
  <div>Description: <?=$task['task_desc']?></div>
  <div>Created by: <?=$get_creator($task['task_created_by_user_id'])?></div>
  <div>Created at: <?=date('D, d-M-y H:i', $task['task_created_at'])?></div>
  <?php if ($task['task_started_at']): ?>
  <div>Started at: <?=date('D, d-M-y H:i', $task['task_started_at'])?></div>
  <?php endif; ?>
  <?php if ($task['task_ended_at']): ?>
  <div>Ended at: <?=date('D, d-M-y H:i', $task['task_ended_at'])?></div>
  <?php endif; ?>
  <div>Deadline at: <?=date('D, d-M-y H:i', $task['task_deadline_at'])?></div>

  <?php if ($task['task_taken_by_user_id'] === $sess_user_id): ?>
  <div>
    <form action="<?=base_url('dashboard/groups')?>" method="post">
      <div>
        <?php if ($task['task_status'] == 2): ?>
        <button type="submit" name="start">Ongoing</button>
        <?php endif; ?>
        <?php if ($task['task_status'] != 9): ?>
        <button type="submit" name="done">Done</button>
        <button type="submit" name="remove">Discontinue</button>
        <?php endif; ?>
      </div>
      <input type="hidden" name="action" value="mark">
      <input type="hidden" name="t_id" value="<?=$task['task_id']?>">
    </form>
  </div>
  <?php endif; ?>

  <?php if (time() >= $task['task_deadline_at'] && !($task['task_status'] == 9 || $task['task_status'] == 8)): ?>
  <div>Warning! Overdue task.</div>
  <?php endif; ?>

</div>