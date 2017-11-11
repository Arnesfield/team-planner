<form action="forgot" method="post">

  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"
      value="<?=set_value('email')?>">
    <?=form_error('email', '<span>', '</span>')?>
  </div>

  <div>
    <button type="submit">Reset</button>
  </div>

</form>