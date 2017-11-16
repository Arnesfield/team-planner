<div class="w-max my-mt-2 mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?=$task['task_name']?></h2>
  </div>

  <div class="mdl-card__supporting-text">
    <div><strong>Description:</strong> <?=$task['task_desc']?></div>
    <div><strong>Created by:</strong> <?=$get_creator($task['task_created_by_user_id'])?></div>
    <div><strong>Created at:</strong> <?=date('D, d-M-y H:i', $task['task_created_at'])?></div>
    <?php if ($task['task_started_at']): ?>
    <div><strong>Started at:</strong> <?=date('D, d-M-y H:i', $task['task_started_at'])?></div>
    <?php endif; ?>
    <?php if ($task['task_ended_at']): ?>
    <div><strong>Ended at:</strong> <?=date('D, d-M-y H:i', $task['task_ended_at'])?></div>
    <?php endif; ?>
    <div><strong>Deadline at:</strong> <?=date('D, d-M-y H:i', $task['task_deadline_at'])?></div>
  </div>

  <?php if ($task['task_taken_by_user_id'] === $sess_user_id): ?>
  <div class="mdl-card__actions mdl-card--border">
    <form action="<?=base_url('dashboard/groups')?>" method="post">
      <div>
        <?php if ($task['task_status'] == 2): ?>
        <button class="mx-xxs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary"
          type="submit" name="start"><i class="material-icons">arrow_forward</i></button>
        <?php endif; ?>
        <?php if (!($task['task_status'] == 9 || $task['task_status'] == 8)): ?>
        <button class="mx-xxs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
          type="submit" name="done"><i class="material-icons">done</i></button>
        <button class="mx-xxs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color-text--white mdl-color--red-A200"
          type="submit" name="remove"><i class="material-icons">close</i></button>
        <?php endif; ?>
      </div>
      <input type="hidden" name="action" value="mark">
      <input type="hidden" name="t_id" value="<?=$task['task_id']?>">
    </form>
  </div>
  <?php endif; ?>

  <?php if (time() >= $task['task_deadline_at'] && !($task['task_status'] == 9 || $task['task_status'] == 8)): ?>
  <div style="background-color: #323232" class="my-p-2 my-mt-2 mdl-color-text--white">Warning! Overdue task.</div>
  <?php endif; ?>

</div>