<form action="forgot/reset" method="post">

  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <?=form_error('password', '<span>', '</span>')?>
  </div>

  <div>
    <label for="passconf">Password Confirmation</label>
    <input type="password" name="passconf" id="passconf">
    <?=form_error('passconf', '<span>', '</span>')?>
  </div>

  <div>
    <button type="submit">Reset</button>
  </div>

</form>