<form action="login" method="post">

  <h3>Login</h3>

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

  <div>
    <a href="<?=base_url('forgot')?>">Forgot password?</a>
    <button type="submit">Login</button>
  </div>

  <div>
    <a href="<?=base_url('signup')?>">Signup</a>
  </div>

</form>