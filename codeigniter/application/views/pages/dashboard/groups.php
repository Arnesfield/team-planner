<div>

<h3>Groups</h3>

<div>
  <a href="<?=base_url('dashboard/create')?>">Create Group</a>
</div>


<?php
// if groups exist
if ($groups): ?>
<div>

  <?php foreach ($groups as $group): ?>
  <div>
    <h4><?=$group['name']?></h4>
    <div><?=$group['description']?></div>
    <a href="<?=base_url('dashboard/groups/' . $group['slug'])?>">Go to group</a>
  </div>
  <?php endforeach; ?>

</div>
<?php else: ?>

<div>
  <h4>You have no groups.</h4>
</div>

<?php endif; ?>

</div>