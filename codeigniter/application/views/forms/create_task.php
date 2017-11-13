<form action="<?=base_url('dashboard/groups')?>" method="post">

  <h3>Create Task</h3>

  <div>
    <label for="name">Task Name</label>
    <input type="text" name="name" id="name"
      value="<?=set_value('name')?>">
    <?=form_error('name', '<span>', '</span>')?>
  </div>

  <div>
    <label for="desc">Description</label>
    <textarea name="desc" id="desc" rows="2"><?=set_value('desc')?></textarea>
    <?=form_error('desc', '<span>', '</span>')?>
  </div>

  <div>
    <label for="assign">Assign to member:</label>
    <select name="assign" id="assign">
      <?php foreach ($members as $key => $member): ?>
      <option value="<?=$member['user_id']?>"
        <?=$member['user_id'] == $sess_user_id ? 'selected' : ''?>>
        <?=$member['username']?>
      </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label for="deadline">Deadline</label>
    <input type="date" name="date" id="deadline"
      min="<?=date('Y-m-d')?>" max="<?=date('Y-m-d', time()+(60*60*24*365))?>"
      value="<?=set_value('date')?>">
    <input type="time" name="time" id="time" value="<?=set_value('time')?>">
    <?=form_error('date', '<span>', '</span>')?>
    <?=form_error('time', '<span>', '</span>')?>
  </div>

  <div>
    <button type="submit">Create</button>
  </div>

  <input type="hidden" name="action" value="create">

</form>