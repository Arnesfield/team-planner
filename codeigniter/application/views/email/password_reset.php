<div>

  <div>
    <h3>Password Reset</h3>
    <p>Dear customer, lorem ipsum dolor sit amet.</p>
    <p>This reset link will only be available until <strong><?=date('l, d F Y H:i:s', $expiration)?></strong>.</p>
  </div>

  <a href="<?=base_url('forgot/reset/' . $code)?>">Reset</a>
  <p>&copy; team-planner project 2017</p>

</div>