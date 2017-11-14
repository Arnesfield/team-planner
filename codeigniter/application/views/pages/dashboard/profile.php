<div>

<div>
  <h3>Profile of <?=$user['username']?></h3>
  <?php if ($allow_edit): ?>
  <a href="<?=base_url('dashboard/profile/' . $user['id'] . '/edit')?>">Edit Profile</a>
  <?php endif; ?>
</div>


</div>