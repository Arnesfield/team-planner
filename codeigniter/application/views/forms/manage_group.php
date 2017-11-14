<form id="users" action="<?=base_url('dashboard/groups/' . $group_id . '/manage')?>" method="post">

  <h3>Manage Group</h3>

  <div>
    <label for="name">Group Name</label>
    <input type="text" name="name" id="name"
      value="<?=set_value('name') ? set_value('name') : $group_info['name']?>">
    <?=form_error('name', '<span>', '</span>')?>
  </div>

  <div>
    <label for="desc">Brief Description</label>
    <textarea name="desc" id="desc" cols="30" rows="10"><?=set_value('desc') ? set_value('desc') : $group_info['description']?></textarea>
    <?=form_error('desc', '<span>', '</span>')?>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" name="status" id="status"
      <?=
        (set_value('status') ? set_value('status') == 'on' : $group_info['status'] == 1)
        ? 'checked' : ''
      ?>>
  </div>

  <div>
    <label for="search_user">Members</label>
    <input type="text" id="search_user" v-model="search">

    <noscript>
      <div>You need <strong>JavaScript</strong> to search for members!</div>
    </noscript>

    <div v-show="true" style="display: none">
      <div v-bind:key="user.id" v-for="user in users">
        <label :for="user.username">
          <div>{{ user.username }} {{ user.email }}</div>
          <div>{{ user.fname }} {{ user.lname }}</div>
          <input type="checkbox" :id="user.username" v-model="selected" :value="user">
        </label>
      </div>
    </div>

    <!-- users selected -->
    <div v-show="true" style="display: none">
      <div v-if="selected.length">
        <strong>Selected</strong>
      </div>
      <div v-bind:key="user.id" v-for="user in selected">
        <div>{{ user.username }} {{ user.email }}</div>
        <div>{{ user.fname }} {{ user.lname }}</div>
        <input type="hidden" name="users[]" :value="user.id">
        <input type="checkbox" :id="user.username" v-model="selected" :value="user">
      </div>
    </div>

  </div>

  <div>
    <button type="submit">Update</button>
    <input type="checkbox" v-model="showPassword" id="delete">
    <label v-if="!showPassword" for="delete">Delete</label>
    <template v-if="showPassword">
      <input type="password" placeholder="Password" v-model="password" :disabled="loading">
      <a @click="deleteGroup" v-if="showDelete">Delete</a>
    </template>
    <template v-if="loading">
      Loading...
    </template>
  </div>


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
    loading: false
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
    // fetch current users and add to selected
    this.setSelected()
  },

  methods: {
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
            console.log(res)
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
          self.users = res
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
          self.selected = res
        },
        'error': function() {
          self.selected = []
        }
      })
    }
  }
})

</script>