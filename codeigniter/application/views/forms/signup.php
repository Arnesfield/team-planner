<form action="signup" method="post" enctype="multipart/form-data">

  <h3>Signup</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('fname') ? 'is-invalid' : '' ?>">
      <input type="text" name="fname" id="fname" value="<?=set_value('fname')?>" maxlength="50"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="fname">First Name</label>
      <span class="mdl-textfield__error"><?=form_error('fname')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('lname') ? 'is-invalid' : '' ?>">
      <input type="text" name="lname" id="lname" value="<?=set_value('lname')?>" maxlength="50"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="lname">Last Name</label>
      <span class="mdl-textfield__error"><?=form_error('lname')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('username') ? 'is-invalid' : '' ?>">
      <input type="text" name="username" id="username" value="<?=set_value('username')?>" maxlength="32"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="username">Username</label>
      <span class="mdl-textfield__error"><?=form_error('username')?></span>
    </div>
  </div>
  
  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('email') ? 'is-invalid' : '' ?>">
      <input type="email" name="email" id="email" value="<?=set_value('email')?>" maxlength="50"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="email">Email</label>
      <span class="mdl-textfield__error"><?=form_error('email')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('bio') ? 'is-invalid' : '' ?>">
      <label class="mdl-textfield__label" for="bio">Bio</label>
      <textarea class="t-area mdl-textfield__input" name="bio" id="bio"><?=set_value('bio')?></textarea>
      <span class="mdl-textfield__error"><?=form_error('bio')?></span>
    </div>
  </div>

  <div class="my-pt-2 my-pb-2">
    <label for="u_image">User Image (optional)</label>
    <input type="file" name="u_image" id="u_image">
    <span class="mdl-textfield__error"><?=form_error('u_image')?></span>
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

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('passconf') ? 'is-invalid' : '' ?>">
      <input type="password" name="passconf" id="passconf"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="passconf">Password Confirmation</label>
      <span class="mdl-textfield__error"><?=form_error('passconf')?></span>
    </div>
  </div>

  <div class="my-mt-3">
    <?=$script?>
    <?=$widget?>
    <br>
    <span class="mdl-color-text--red-A700"><?=form_error('g-recaptcha-response')?></span>
  </div>

  <div class="my-mt-3">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Signup</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      href="<?=base_url('login')?>">Back to Login</a>
  </div>

</form>