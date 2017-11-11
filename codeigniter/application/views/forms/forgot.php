<form action="forgot" method="post">

  <h3>Forgot Password</h3>

  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"
      value="<?=set_value('email')?>">
    <?=form_error('email', '<span>', '</span>')?>
  </div>

  <div>
    <a href="<?=base_url('login')?>">Login</a>
    <button type="submit">Reset</button>
  </div>

</form>