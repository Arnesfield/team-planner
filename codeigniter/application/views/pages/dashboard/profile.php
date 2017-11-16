<div class="container-fluid">

<div class="row">
  <div class="col-md-4 col-sm-4">
    <div>
      <?php if ($user['u_image']): ?>
      <img src="<?=base_url('uploads/images/users/' . $user['u_image'])?>"
        class="w-max" alt="<?=$user['u_image']?>">
      <?php else: ?>
      <div>No profile image</div>
      <?php endif; ?>
    </div>
    <h3>Profile of <?=$user['username']?></h3>
    <?php if ($allow_edit): ?>
    <a href="<?=base_url('dashboard/profile/' . $user['id'] . '/edit')?>">Edit Profile</a>
    <?php endif; ?>
  </div>
  <div class="col-md-8 col-sm-8">
    <div>
      <div>Username:</div>
      <h4><?=$user['username']?></h4>
    </div>
    <div>
      <div>Name:</div>
      <h4><?=$user['fname'] . ' ' . $user['lname']?></h4>
    </div>
    <div>
      <div>Email:</div>
      <h4><?=$user['email']?></h4>
    </div>
    <div>
      <div>Bio:</div>
      <h4><?=$user['bio']?></h4>
    </div>
  </div>
</div>

</div>