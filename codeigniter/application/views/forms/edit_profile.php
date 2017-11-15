<form id="profile" action="<?=base_url('dashboard/profile')?>" method="post" enctype="multipart/form-data">

  <h3>Edit Profile</h3>

  <div>
    <label for="fname">First Name</label>
    <input type="text" name="fname" id="fname"
      value="<?=$write_val('fname', $user)?>">
    <?=form_error('fname', '<span>', '</span>')?>
  </div>

  <div>
    <label for="lname">Last Name</label>
    <input type="text" name="lname" id="lname"
      value="<?=$write_val('lname', $user)?>">
    <?=form_error('lname', '<span>', '</span>')?>
  </div>

  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username"
      value="<?=$write_val('username', $user)?>">
    <?=form_error('username', '<span>', '</span>')?>
  </div>
  
  <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email"
      value="<?=$write_val('email', $user)?>">
    <?=form_error('email', '<span>', '</span>')?>
  </div>

  <div>
    <label for="bio">Bio</label>
    <textarea name="bio" id="bio"><?=$write_val('bio', $user)?></textarea>
    <?=form_error('bio', '<span>', '</span>')?>
  </div>

  <div>
    <div>
      <?php if ($user['u_image']): ?>
      <label for="">Current Image</label>
      <img src="<?=base_url('uploads/images/users/' . $user['u_image'])?>" alt="<?=$user['username']?>">
      <?php else: ?>
      <label for="">No current image</label>
      <?php endif; ?>
    </div>

    <div>
      <label for="u_image">User Image (optional)</label>
      <input type="file" name="u_image" id="u_image">
      <?=form_error('u_image', '<span>', '</span>')?>
    </div>
  </div>

  <div>
    <span><label for="renew">Renew password:</label> <input type="checkbox" id="renew" v-model="disabled"></span>
  </div>

  <div>
    <label for="old_password">Old Password</label>
    <input type="password" name="old_password" id="old_password" v-model="oldPassword" value="" :disabled="!disabled">
    <?=form_error('old_password', '<span>', '</span>')?>
  </div>

  <div>
    <label for="password">New Password</label>
    <input type="password" name="password" id="password" v-model="password" value="" :disabled="!disabled">
    <?=form_error('password', '<span>', '</span>')?>
  </div>

  <div>
    <label for="passconf">Password Confirmation</label>
    <input type="password" name="passconf" id="passconf" v-model="passconf" value="" :disabled="!disabled">
    <?=form_error('passconf', '<span>', '</span>')?>
  </div>

  <div>
    <button type="submit">Update</button>
    <a @click="view">View Profile</a>
  </div>

</form>

<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#profile',
  data: {
    disabled: false,
    password: '',
    passconf: '',
    oldPassword: ''
  },
  watch: {
    disabled(to, from) {
      if (to === false) {
        this.password = ''
        this.passconf = ''
        this.oldPassword = ''
      }
    }
  },

  methods: {
    view() {
      window.location = "<?=base_url('dashboard/profile/' . $user['id'])?>";
    }
  }
})
</script>