<form action="<?=base_url('dashboard/create')?>" method="post" enctype="multipart/form-data">

  <h3>Create Group</h3>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('name') ? 'is-invalid' : '' ?>">
      <input type="text" name="name" id="name" value="<?=set_value('name')?>"
        class="mdl-textfield__input">
      <label class="mdl-textfield__label" for="name">Group Name</label>
      <span class="mdl-textfield__error"><?=form_error('name')?></span>
    </div>
  </div>

  <div>
    <div class="w-max my-mt-1 mdl-textfield mdl-js-textfield mdl-textfield--floating-label
      <?=form_error('desc') ? 'is-invalid' : '' ?>">
      <textarea name="desc" id="desc"
        class="t-area mdl-textfield__input"><?=set_value('desc')?></textarea>
      <label class="mdl-textfield__label" for="desc">Brief Description</label>
      <span class="mdl-textfield__error"><?=form_error('desc')?></span>
    </div>
  </div>

  <div class="my-pt-2 my-pb-2">
    <label for="g_image">Group Image (optional)</label>
    <input type="file" name="g_image" id="g_image">
    <?=form_error('g_image', '<span>', '</span>')?>
  </div>

  <div id="users">
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
          </div>
        </div>
        
        <input type="hidden" name="users[]" :value="user.id">
      </div>
    </div>

  </div>

  <div class="my-mt-3">
    <button class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
      type="submit">Create</button>
    <a class="mx-xs mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
      href="<?=base_url('dashboard/groups')?>">View My Groups</a>
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