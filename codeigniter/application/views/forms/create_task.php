<form action="<?=base_url('dashboard/groups')?>" method="post">

  <h3>Create Task</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('name') ? 'is-invalid' : '' ?>">
      <input type="text" name="name" id="name" value="<?=set_value('name')?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="name">Task Name</label>
      <span class="mdl-textfield__error"><?=form_error('name')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('desc') ? 'is-invalid' : '' ?>">
      <textarea name="desc" id="desc"
        class="t-area mdl-textfield__input"><?=set_value('desc')?></textarea>
      <label class="mdl-textfield__label" for="desc">Description</label>
      <span class="mdl-textfield__error"><?=form_error('desc')?></span>
    </div>
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
    <div>
      <span class="mdl-color-text--red-A700"><?=form_error('date')?></span>
      <span class="mdl-color-text--red-A700"><?=form_error('time')?></span>
    </div>
  </div>

  <div class="my-mt-2">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Create</button>
  </div>

  <input type="hidden" name="action" value="create">

</form>