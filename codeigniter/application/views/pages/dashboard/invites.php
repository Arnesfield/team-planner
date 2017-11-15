<div>

<?php
// if groups exist
if ($groups): ?>
<div>

  <?php foreach ($groups as $key => $group): ?>
  <form action="<?=base_url('dashboard/accept_invite')?>" method="post">
    <div>
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
      <button type="submit" name="accept">Accept</button>
      <button type="submit" name="reject">Reject</button>
    </div>
  </form>
  <?php endforeach; ?>

</div>
<?php else: ?>

<div>
  <h4>You have no group invitations.</h4>
</div>

<?php endif; ?>

</div>