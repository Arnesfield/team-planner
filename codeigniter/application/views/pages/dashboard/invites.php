<div class="content">
<div class="pad">

<div>

<?php
// if groups exist
if ($groups): ?>
<div>

  <?php foreach ($groups as $key => $group): ?>
  <?php if ($key % 4 == 0 || $key == 0): ?>
    <div class="row">
  <?php endif; ?>
  <form class="my-mt-3 col-md-3 col-sm-6" action="<?=base_url('dashboard/accept_invite')?>" method="post">
    <div>
      <div>
        <img class="w-max" src="<?=base_url('uploads/images/groups/' . $group['group_image'])?>" alt="<?=$group['group_name']?>">
      </div>
      <h4><?=$group['group_name']?></h4>
      <div><?=$group['group_desc']?></div>
      <?php if (isset($owners) && $owners[$key]): ?>
      <div>
        Admins:
        <?php foreach ($owners[$key] as $owner_key => $owner): ?>
          <a href="<?=base_url('dashboard/profile/' . $owner['user_id'])?>" target="_blank">
          <?=$owner['username']?></a><?=count($owners[$key]) > 1 && $owner_key !== count($owners[$key])-1 ? ', ' : ''?>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <input type="hidden" name="group" value="<?=$group['group_id']?>">
      <button class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
        type="submit" name="accept">Accept</button>
      <button class="my-mt-2 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-A200 mdl-color-text--white"
        type="submit" name="reject">Reject</button>
    </div>
  </form>
  <?php if (($key+1) % 4 == 0): ?>
    </div>
  <?php endif; ?>
  <?php endforeach; ?>

</div>
<?php else: ?>

<div>
  <h4>You have no group invitations.</h4>
</div>

<?php endif; ?>

</div>

</div>
</div>