<form action="<?=base_url('dashboard/add_members')?>" method="post">

  <h3>Add members</h3>

  <div id="users">
    <div>
      <div class="my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input type="text" id="search_user" v-model="search"
          class="mdl-textfield__input">
        <label class="mdl-textfield__label" for="search_user">Members</label>
      </div>
      
      <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
        type="submit" v-if="selected.length">Invite</button>
    </div>

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
          </div>
        </div>
        
        <input type="hidden" name="users[]" :value="user.id">
      </div>
    </div>

  </div>

</form>

<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#users',
  data: {
    users: [],
    selected: [],
    search: '',
    profileUrl: "<?=base_url('dashboard/profile/')?>",
    usersImageUrl: "<?=base_url('uploads/images/users/')?>"
  },

  watch: {
    search(to, from) {
      if (to !== from) {
        this.searchUsers()
      }
    }
  },

  methods: {
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
      
    }
  }
})

</script>