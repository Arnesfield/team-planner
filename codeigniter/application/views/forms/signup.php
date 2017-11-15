<form action="signup" method="post" enctype="multipart/form-data">

  <h3>Signup</h3>

  <div>
    <label for="fname">First Name</label>
    <input type="text" name="fname" id="fname"
      value="<?=set_value('fname')?>">
    <?=form_error('fname', '<span>', '</span>')?>
  </div>

  <div>
    <label for="lname">Last Name</label>
    <input type="text" name="lname" id="lname"
      value="<?=set_value('lname')?>">
    <?=form_error('lname', '<span>', '</span>')?>
  </div>

  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username"
      value="<?=set_value('username')?>">
    <?=form_error('username', '<span>', '</span>')?>
  </div>
  
  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"
      value="<?=set_value('email')?>">
    <?=form_error('email', '<span>', '</span>')?>
  </div>

  <div>
    <label for="bio">Bio</label>
    <textarea name="bio" id="bio"><?=set_value('bio')?></textarea>
    <?=form_error('bio', '<span>', '</span>')?>
  </div>

  <div>
    <label for="u_image">User Image (optional)</label>
    <input type="file" name="u_image" id="u_image">
    <?=form_error('u_image', '<span>', '</span>')?>
  </div>

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
    <?=$script?>
    <?=$widget?>
    <?=form_error('g-recaptcha-response', '<span>', '</span>')?>
  </div>

  <div>
    <a href="<?=base_url('login')?>">Login</a>
    <button type="submit">Signup</button>
  </div>

</form>