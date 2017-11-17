<table>

  <thead>
    <h1 style="color: #3F51B5;">
      <img style="vertical-align: middle; display: inline-block; width: 32px; height: 32px"
        src="<?=base_url('assets/images/logo.png')?>">
      <span style="vertical-align: middle;">Team-Planner</span>
    </h1>
  </thead>

  <tbody>
    <h3>Email Verification</h3>
    <p>Dear customer,</p>
    <p>
      We need you to confirm this email address in order to get started with colaborating with your peers. Email confirmation is simple and fast, just click on the link below to complete this process.
    </p>
    <a style="color: #ff4081" href="<?=base_url('signup/verify/' . $code)?>">Verify email address</a>
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