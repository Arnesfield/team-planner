<form id="users" action="<?=base_url('dashboard/groups/' . $group_id . '/manage')?>" method="post" enctype="multipart/form-data">

  <h3>Manage Group</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('name') ? 'is-invalid' : '' ?>">
      <input type="text" name="name" id="name"
        value="<?=set_value('name') ? set_value('name') : $group_info['name']?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="name">Group Name</label>
      <span class="mdl-textfield__error"><?=form_error('name')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('desc') ? 'is-invalid' : '' ?>">
      <textarea name="desc" id="desc"
        class="t-area mdl-textfield__input"><?=set_value('desc') ? set_value('desc') : $group_info['description']?></textarea>
      <label class="mdl-textfield__label" for="desc">Brief Description</label>
      <span class="mdl-textfield__error"><?=form_error('desc')?></span>
    </div>
  </div>

  <div>
    <div class="my-pt-2 my-pb-2">
      <?php if ($group_info['g_image']): ?>
      <label for="">Current Image</label>
      <img src="<?=base_url('uploads/images/groups/' . $group_info['g_image'])?>" alt="<?=$group_info['name']?>"
        style="width: 48px">
      <?php else: ?>
      <label for="">No current image</label>
      <?php endif; ?>
    </div>

    <div>
      <label for="g_image">Group Image (optional)</label>
      <input type="file" name="g_image" id="g_image">
      <span class="mdl-textfield__error"><?=form_error('g_image')?></span>
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

  <div>
    <!-- <label for="status">Active</label>
    <input type="checkbox" name="status" id="status"
      <?=
        (set_value('status') ? set_value('status') == 'on' : $group_info['status'] == 1)
        ? 'checked' : ''
      ?>> -->

    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" 
      for="status">
      <input type="checkbox" name="status" id="status"
          class="mdl-checkbox__input"
          <?=
            (set_value('status') ? set_value('status') == 'on' : $group_info['status'] == 1)
            ? 'checked' : ''
          ?>>
      <span class="mdl-checkbox__label">Active</span>
    </label>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
      <input type="text" id="search_user" v-model="search"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="search_user">Members</label>
    </div>

    <!-- <label for="search_user">Members</label>
    <input type="text" id="search_user" v-model="search"> -->

    <noscript>
      <div>You need <strong>JavaScript</strong> to search for members!</div>
    </noscript>

    <div v-if="users.length" class="my-mt-2 search-max" v-show="true" style="display: none">
      <div class="my-mb-2" v-bind:key="user.id" v-for="user in users">
        <label :for="user.username">

          <div style="display: inline-block; vertical-align: 100%; width: 52px;">
            <img style="width: inherit; display: inline"
              :src="usersImageUrl + user.u_image" :alt="user.username">
          </div>
          &nbsp;
          <div style="display: inline">
            <div style="display: inline-block">
              <a :href="profileUrl + user.id" target="_blank">{{ user.username }}</a>
              | {{ user.fname }} {{ user.lname }}
              <br>
              <span>{{ user.email }}</span>
              <br>
              <input type="checkbox" :id="user.username" v-model="selected" :value="user">
            </div>
          </div>

        </label>
      </div>
    </div>

    <!-- users selected -->
    <div v-if="selected.length" v-show="true" style="display: none">
      <div>
        <h6>Selected</h6>
      </div>
      <div class="my-mb-2" v-bind:key="user.id" v-for="user in selected">
        <div style="display: inline-block; vertical-align: 100%; width: 52px;">
          <img style="width: inherit; display: inline"
            :src="usersImageUrl + user.u_image" :alt="user.username">
        </div>
        &nbsp;
        <div style="display: inline">
          <div style="display: inline-block">
            <a :href="profileUrl + user.id" target="_blank">{{ user.username }}</a>
            | {{ user.fname }} {{ user.lname }}
            <br>
            <span>{{ user.email }}</span>
            <br>
            <input type="checkbox" :id="user.username" v-model="selected" :value="user">
            |
            <div style="display: inline-block">
              <input type="checkbox" :id="user.username + '-is-admin'" v-model="isAdmin[user.id]" :value="user">
              <label :for="user.username + '-is-admin'" :style="{ 'text-decoration': (isAdmin[user.id] ? '' : 'line-through') }">Admin</span>
              <input v-if="isAdmin[user.id]" type="hidden" name="admins[]" :value="user.id">
            </div>
          </div>
        </div>
        
        <input type="hidden" name="users[]" :value="user.id">
      </div>
    </div>

  </div>

  <div class="my-mt-2">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Update</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      @click="back">View Group</a>

    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" style="display: inline"
      for="delete">
      <input type="checkbox" id="delete" v-model="showPassword"
        class="mdl-checkbox__input">
      <span v-if="!showPassword" class="mdl-checkbox__label">Delete</span>
    </label>

    <!-- <input type="checkbox" v-model="showPassword" id="delete">
    <label v-if="!showPassword" for="delete">Delete</label> -->
    <template>
      <!-- <input type="password" placeholder="Password" v-model="password" :disabled="loading"> -->
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
        :style="{ 'display': showPassword ? '' : 'none'}">
        <input type="password" v-model="password" :disabled="loading"
          class="mdl-textfield__input">
        <label class="mdl-textfield__label" for="search_user">Password</label>
      </div>
      <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--deep-orange-A200 mdl-color-text--white"
        @click="deleteGroup" v-if="showDelete">Delete</a>
    </template>
    <template v-if="loading">
      Loading...
    </template>
  </div>

  <span id="isjs"></span>
  <input type="hidden" name="action" value="manage">

</form>

<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#users',
  data: {
    users: [],
    selected: [],
    search: '',
    password: '',
    showPassword: false,
    showDelete: false,
    loading: false,
    profileUrl: "<?=base_url('dashboard/profile/')?>",
    usersImageUrl: "<?=base_url('uploads/images/users/')?>",
    isAdmin: []
  },

  watch: {
    search(to, from) {
      if (to !== from) {
        this.searchUsers()
      }
    },
    password(to, from) {
      this.showDelete = Boolean(to)
    },
    showPassword(to, from) {
      if (to === false) {
        // empty password field
        this.password = ''
      }
    }
  },

  created() {
    // to check if javascript is enabled, lol
    $('#isjs').html('<input type="hidden" name="isjs" value="1">')
    // fetch current users and add to selected
    this.setSelected()
  },

  methods: {
    back() {
      window.location = "<?=base_url('dashboard/groups/' . $group_id)?>"
    },

    deleteGroup() {
      const id = <?=$group_id?>;
      if (confirm('Are you sure you want to delete this group?')) {
        const self = this
        $.ajax({
          'method': 'POST',
          'url': '<?=base_url('dashboard/delete_group')?>',
          'dataType': 'JSON',
          'data': {
            'delete': id,
            'password': self.password
          },
          'success': function(res) {
            // console.log(res)
            if (res.success == 1) {
              window.location = "<?=base_url('dashboard/groups')?>"
            }
            else if (res.message) {
              alert(res.message)
            }
          },
          'error': function() {
            alert('Unable to delete group.')
          },
          'complete': function() {
            self.loading = false
          }
        })

        // clean password
        this.password = ''
        this.loading = true

      }
    },

    searchUsers() {
      // ajax
      const self = this
      $.ajax({
        'method': 'POST',
        'url': '<?=base_url('dashboard/users_json')?>',
        'dataType': 'JSON',
        'data': {
          'text': self.search
        },
        'success': function(res) {
          self.users = res.users
        },
        'error': function() {
          self.users = []
        }
      })
      
    },

    setSelected() {
      // ajax
      const self = this
      $.ajax({
        'method': 'POST',
        'url': '<?=base_url('dashboard/users_json')?>',
        'dataType': 'JSON',
        'data': {
          'update': true
        },
        'success': function(res) {
          self.selected = res.users
          // make true in isAdmin[] if type is 1
          self.selected.forEach((e, i) => {
            self.isAdmin[e.id] = res.types[e.id] == 1
          })
        },
        'error': function() {
          self.selected = []
        }
      })
    }
  }
})

</script>