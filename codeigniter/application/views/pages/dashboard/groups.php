<div class="content">
<div class="pad">

<h3>Groups</h3>

<div>
  <a href="<?=base_url('dashboard/create')?>">Create Group</a>
</div>

<?php
// if invited groups exist
if ($invited_groups): ?>
<div>

  <div>
    <span>You have <strong><?=$count = count($invited_groups)?></strong> group invitation<?=$count > 1 ? 's' : ''?>.</span>
    <a href="<?=base_url('dashboard/invites')?>">View Group Invites</a>
  </div>

</div>
<?php endif; ?>

<?php
// if groups exist
if ($groups): ?>
<div>

  <?php if ($my_groups): ?>
  <div>
    <h4>My Groups</h4>
    <hr>

    <?php foreach ($my_groups as $group): ?>
    <div>
      <div>
        <img src="<?=base_url('uploads/images/groups/' . $group['group_image'])?>" alt="<?=$group['group_name']?>"
          style="width: 256px">
      </div>
      <h4><?=$group['group_name']?></h4>
      <div><?=$group['group_desc']?></div>
      <a class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        href="<?=base_url('dashboard/groups/' . $group['group_id'])?>">Go to group</a>
    </div>
    <?php endforeach; ?>

  </div>
  <?php endif; ?>

  <?php if ($other_groups): ?>
  <div>
    <h4>Other Groups</h4>
    <hr>

    <?php foreach ($other_groups as $group): ?>
    <div>
      <div>
        <img src="<?=base_url('uploads/images/users/' . $group['group_image'])?>" alt="<?=$group['group_name']?>"
          style="width: 256px">
      </div>
      <h4><?=$group['group_name']?></h4>
      <div><?=$group['group_desc']?></div>
      <a class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        href="<?=base_url('dashboard/groups/' . $group['group_id'])?>">Go to group</a>
    </div>
    <?php endforeach; ?>

  </div>
  <?php endif; ?>

</div>
<?php else: ?>

<div>
  <h4>You have no groups.</h4>
</div>

<?php endif; ?>

</div>
</div>