<form action="<?=base_url('dashboard/add_members')?>" method="post">

  <h3>Add members</h3>

  <div id="users">
    <label for="search_user">Members</label>
    <input type="text" id="search_user" v-model="search">
    <button type="submit" v-if="selected.length">Invite</button>

    <noscript>
      <div>You need <strong>JavaScript</strong> to search for members!</div>
    </noscript>

    <div v-show="true" style="display: none">
      <div v-bind:key="user.id" v-for="user in users">
        <label :for="user.username">
          <div>{{ user.username }} {{ user.email }}</div>
          <div>{{ user.fname }} {{ user.lname }}</div>
          <div>
            <a :href="profileUrl + user.id" target="_blank">View Profile</a>
          </div>
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
        <div>
          <a :href="profileUrl + user.id" target="_blank">View Profile</a>
        </div>
        <input type="checkbox" :id="user.username" v-model="selected" :value="user">
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
    profileUrl: "<?=base_url('dashboard/profile/')?>"
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
          self.users = res
        },
        'error': function() {
          self.users = []
        }
      })
      
    }
  }
})

</script>