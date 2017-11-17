<form id="profile" action="<?=base_url('dashboard/profile')?>" method="post" enctype="multipart/form-data">

  <h3>Edit Profile</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('fname') ? 'is-invalid' : '' ?>">
      <input type="text" name="fname" id="fname" value="<?=$write_val('fname', $user)?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="fname">First Name</label>
      <span class="mdl-textfield__error"><?=form_error('fname')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('lname') ? 'is-invalid' : '' ?>">
      <input type="text" name="lname" id="lname" value="<?=$write_val('lname', $user)?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="lname">Last Name</label>
      <span class="mdl-textfield__error"><?=form_error('lname')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('username') ? 'is-invalid' : '' ?>">
      <input type="text" name="username" id="username" value="<?=$write_val('username', $user)?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="username">Username</label>
      <span class="mdl-textfield__error"><?=form_error('username')?></span>
    </div>
  </div>
  
  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('email') ? 'is-invalid' : '' ?>">
      <input type="email" name="email" id="email" value="<?=$write_val('email', $user)?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="email">Email</label>
      <span class="mdl-textfield__error"><?=form_error('email')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('bio') ? 'is-invalid' : '' ?>">
      <label class="mdl-textfield__label" for="bio">Bio</label>
      <textarea class="t-area mdl-textfield__input" name="bio" id="bio"><?=$write_val('bio', $user)?></textarea>
      <span class="mdl-textfield__error"><?=form_error('bio')?></span>
    </div>
  </div>

  <div>
    <div class="my-pt-2 my-pb-2">
      <?php if ($user['u_image']): ?>
      <label for="">Current Image&nbsp;</label>
      <img src="<?=base_url('uploads/images/users/' . $user['u_image'])?>" alt="<?=$user['username']?>"
        style="width: 48px">
      <?php else: ?>
      <label for="">No current image</label>
      <?php endif; ?>

      <div>
        <label for="u_image">User Image (optional)</label>
        <input type="file" name="u_image" id="u_image">
        <span class="mdl-textfield__error"><?=form_error('u_image')?></span>
      </div>

      <div class="my-mt-2">
        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect"
          for="remove_image">
          <input type="checkbox" name="remove_image" id="remove_image"
              class="mdl-checkbox__input">
          <span class="mdl-checkbox__label">Remove Image</span>
        </label>
  
        <!-- <label for="remove_image">Remove Image</label> -->
        <!-- <input type="checkbox" name="remove_image" id="remove_image"> -->
      </div>

    </div>

  </div>

  <div>
    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" 
      for="renew">
      <input type="checkbox" name="renew" id="renew" v-model="disabled"
          class="mdl-checkbox__input">
      <span class="mdl-checkbox__label">Renew Password</span>
    </label>

    <!-- <span><label for="renew">Renew password:</label> <input type="checkbox" id="renew" v-model="disabled"></span> -->
  </div>

  <div>
    <div :class="[{'is-disabled': !disabled},
      'w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=form_error('old_password') ? 'is-invalid' : '' ?>']">
      <input type="password" name="old_password" id="old_password"
        v-model="oldPassword" value="" :disabled="!disabled"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="old_password">Old Password</label>
      <span class="mdl-textfield__error"><?=form_error('old_password')?></span>
    </div>

    <!-- <label for="old_password">Old Password</label>
    <input type="password" name="old_password" id="old_password" v-model="oldPassword" value="" :disabled="!disabled">
    <span class="mdl-textfield__error"><?=form_error('old_password')?></span> -->
  </div>

  <div>
    <div :class="[{'is-disabled': !disabled},
      'w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=form_error('password') ? 'is-invalid' : '' ?>']">
      <input type="password" name="password" id="password"
        v-model="password" value="" :disabled="!disabled"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="password">New Password</label>
      <span class="mdl-textfield__error"><?=form_error('password')?></span>
    </div>

    <!-- <label for="password">New Password</label>
    <input type="password" name="password" id="password" v-model="password" value="" :disabled="!disabled">
    <span class="mdl-textfield__error"><?=form_error('password')?></span> -->
  </div>

  <div>
    <div :class="[{'is-disabled': !disabled},
      'w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label <?=form_error('passconf') ? 'is-invalid' : '' ?>']">
      <input type="password" name="passconf" id="passconf"
        v-model="passconf" value="" :disabled="!disabled"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="passconf">Password Confirmation</label>
      <span class="mdl-textfield__error"><?=form_error('passconf')?></span>
    </div>

    <!-- <label for="passconf">Password Confirmation</label>
    <input type="password" name="passconf" id="passconf" v-model="passconf" value="" :disabled="!disabled">
    <span class="mdl-textfield__error"><?=form_error('passconf')?></span> -->
  </div>

  <div class="my-flex my-mt-3">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Update</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      @click="view">View Profile</a>
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