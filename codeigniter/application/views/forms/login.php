<form action="login" method="post">

  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username"
      value="<?=set_value('username')?>">
    <?=form_error('username', '<span>', '</span>')?>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <?=form_error('password', '<span>', '</span>')?>
  </div>

  <?php if (isset($invalid) && $invalid): ?>
  <div>
    Invalid username or password.
  </div>
  <?php endif; ?>

  <div>
    <button type="submit">Login</button>
  </div>

</form>