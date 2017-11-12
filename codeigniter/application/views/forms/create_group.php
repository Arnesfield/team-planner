<form action="<?=base_url('dashboard/create')?>" method="post">

  <h3>Create Group</h3>

  <div>
    <label for="name">Group Name</label>
    <input type="text" name="name" id="name"
      value="<?=set_value('name')?>">
    <?=form_error('name', '<span>', '</span>')?>
  </div>

  <div>
    <label for="desc">Brief Description</label>
    <textarea name="desc" id="desc" cols="30" rows="10"><?=set_value('desc')?></textarea>
    <?=form_error('desc', '<span>', '</span>')?>
  </div>

  <div id="users">
    <label for="search_user">Members</label>
    <input type="text" id="search_user" v-model="search">

    <noscript>
      <div>You need <strong>JavaScript</strong> to search for members!</div>
    </noscript>

    <div v-show="true" style="display: none">
      <label :for="user.username" v-bind:key="user.id" v-for="user in users">
        <div>{{ user.username }} {{ user.email }}</div>
        <div>{{ user.fname }} {{ user.lname }}</div>
        <input type="checkbox" :id="user.username" v-model="selected" :value="user">
      </label>
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
    <button type="submit">Create</button>
  </div>

</form>

<script>
new Vue({
  el: '#users',
  data: {
    users: [],
    selected: [],
    search: ''
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
          'text': $('#search_user').val()
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