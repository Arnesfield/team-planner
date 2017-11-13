<div>

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

    <?php foreach ($my_groups as $group): ?>
    <div>
      <h4><?=$group['name']?></h4>
      <div><?=$group['description']?></div>
      <a href="<?=base_url('dashboard/groups/' . $group['slug'])?>">Go to group</a>
    </div>
    <?php endforeach; ?>

  </div>
  <?php endif; ?>

  <?php if ($other_groups): ?>
  <div>
    <h4>Other Groups</h4>

    <?php foreach ($other_groups as $group): ?>
    <div>
      <h4><?=$group['name']?></h4>
      <div><?=$group['description']?></div>
      <a href="<?=base_url('dashboard/groups/' . $group['slug'])?>">Go to group</a>
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