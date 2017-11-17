<form action="login" method="post">

  <h3>Login</h3>

  <div>

    <div class="w-max mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('username') ? 'is-invalid' : '' ?>">
      <input type="text" name="username" id="username" maxlength="32" value="<?=set_value('username')?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="username">Username</label>
      <span class="mdl-textfield__error"><?=form_error('username')?></span>
    </div>

  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('password') ? 'is-invalid' : '' ?>">
      <input type="password" name="password" id="password"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="password">Password</label>
      <span class="mdl-textfield__error"><?=form_error('password')?></span>
    </div>
  </div>

  <div class="my-flex my-mt-3">
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      href="<?=base_url('forgot')?>">Forgot password?</a>
    <span style="flex: 1"></span>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary"
      href="<?=base_url('signup')?>">Signup</a>
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Login</button>
  </div>

</form>