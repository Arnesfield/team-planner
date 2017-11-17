<form action="forgot/reset" method="post">

  <h3>Password Reset</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('password') ? 'is-invalid' : '' ?>">
      <input type="password" name="password" id="password" maxlength="50"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="password">Password</label>
      <span class="mdl-textfield__error"><?=form_error('password')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('passconf') ? 'is-invalid' : '' ?>">
      <input type="password" name="passconf" id="passconf" maxlength="50"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="passconf">Password Confirmation</label>
      <span class="mdl-textfield__error"><?=form_error('passconf')?></span>
    </div>
  </div>

  <div class="my-mt-3">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Reset</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      href="<?=base_url('login')?>">Back to Login</a>
  </div>

</form>