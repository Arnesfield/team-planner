<form action="forgot" method="post">

  <h3>Forgot Password</h3>

  <div>
  
    <div class="w-max mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('email') ? 'is-invalid' : '' ?>">
      <input type="email" name="email" id="email" value="<?=set_value('email')?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="email">Email</label>
      <span class="mdl-textfield__error"><?=form_error('email')?></span>
    </div>

  </div>

  <div class="my-mt-3">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Reset</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      href="<?=base_url('login')?>">Back to Login</a>
  </div>

</form>