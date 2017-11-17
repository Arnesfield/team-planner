<table>

  <thead>
    <h1 style="color: #3F51B5;">
      <img style="vertical-align: middle; display: inline-block; width: 32px; height: 32px"
        src="<?=base_url('assets/images/logo.png')?>">
      <span style="vertical-align: middle;">Team-Planner</span>
    </h1>
  </thead>

  <tbody>
    <h3>Password Reset</h3>
    <p>Dear customer,</p>
    <p>
      You have asked for an account password reset. No worries, resetting your account password is easy. Please click the link below to reset your account password.
    </p>
    <a style="color: #ff4081" href="<?=base_url('forgot/reset/' . $code)?>">Reset password</a>
    <p style="margin-bottom: 0">This reset link will only be available until <strong style="color: #ff6e40"><?=date('l, d F Y H:i:s', $expiration)?></strong>.</p>
  </tbody>

  <tfoot>
    <div style="padding-top: 24px;">
      <small>
        <p style="color: #757575">
          Email sent to <span style="color: #ff4081; text-decoration: underline"><?=$email?></span>
          at <strong><?=date('l, d F Y H:i:s')?></strong>.
          <br><br>
          ITWSPEC6 Final Project.
          <br>
          FEUTECH &copy; 2017-2018. Team-Planner Web Application.
        </p>
      </small>
    </div>
  </tfoot>

</table>