<div class="content">
<div class="pad">

<h3>Groups</h3>

<div>
  <a class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
    href="<?=base_url('dashboard/create')?>">Create Group</a>
</div>

<?php
// if invited groups exist
if ($invited_groups): ?>
<div class="my-mt-3">

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

    <?php foreach ($my_groups as $i => $group): ?>
    <?php if ($i % 4 == 0 || $i == 0): ?>
      <div class="row">
    <?php endif; ?>
    <div class="col-md-3 col-sm-6 my-mt-3">
      <div>
        <img src="<?=base_url('uploads/images/groups/' . $group['group_image'])?>" alt="<?=$group['group_name']?>"
          style="width: 100%">
      </div>
      <h4><?=$group['group_name']?></h4>
      <div><?=$group['group_desc']?></div>
      <a class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        href="<?=base_url('dashboard/groups/' . $group['group_id'])?>">Go to group</a>
    </div>
    <?php if (($i+1) % 4 == 0): ?>
      </div>
    <?php endif; ?>
    <?php endforeach; ?>

  </div>
  <?php endif; ?>

  <?php if ($other_groups): ?>
  <div>
    <h4>Other Groups</h4>
    <hr>

    <?php foreach ($other_groups as $i => $group): ?>
    <?php if ($i % 4 == 0 || $i == 0): ?>
      <div class="row">
    <?php endif; ?>
    <div class="col-md-3 col-sm-6 my-mt-3">
      <div>
        <img src="<?=base_url('uploads/images/groups/' . $group['group_image'])?>" alt="<?=$group['group_name']?>"
          style="width: 100%">
      </div>
      <h4><?=$group['group_name']?></h4>
      <div><?=$group['group_desc']?></div>
      <a class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        href="<?=base_url('dashboard/groups/' . $group['group_id'])?>">Go to group</a>
    </div>
    <?php if (($i+1) % 4 == 0): ?>
      </div>
    <?php endif; ?>
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