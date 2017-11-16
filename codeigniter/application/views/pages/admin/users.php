<div class="content">
<div class="pad">

<div id="users">

<h3>Users</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<table id="tblUsers" style="display: none" v-show="true">
  <thead>
    <tr>
      <th>User ID</th>
      <th>Image</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Bio</th>
      <th>Type</th>
      <th>No. of Memberships</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr :key="user.id" v-for="user in users">
      <td>{{ user.id }}</td>
      <td>
        <template v-if="user.u_image">
          <img style="width: 52px; margin: 0 auto; display: block"
            :src="'<?=base_url('uploads/images/users/')?>' + user.u_image" :alt="'img-' + user.id"/>
        </template>
        <template v-else>No image</template>
      </td>
      <td><a :href="profileUrl + user.id" target="_blank">{{ user.username }}</a></td>
      <td>{{ user.fname }}</td>
      <td>{{ user.lname }}</td>
      <td>{{ user.email }}</td>
      <td>{{ user.bio }}</td>
      <td>
        <input v-if="currUserId != user.id" type="checkbox"
          :id="'type-' + user.id" :checked="user.type == 1" @click="changeType(user)">
        <label :for="'type-' + user.id">{{
          user.type == 1 ? 'Admin' : 'Member'
        }}</label>
      </td>
      <td>{{ user.no_of_memberships }}</td>
      <td>
        <input v-if="currUserId != user.id" type="checkbox"
          :id="'status-' + user.id" :checked="user.status == 1" @click="changeStatus(user)">
        <label :for="'status-' + user.id">
          {{
          user.status == 1
            ? 'Activated'
            : user.status == 2
              ? 'Unverified'
              : 'Deactivated'
          }}
        </label>
      </td>
    </tr>
  </tbody>
</table>
</div>

</div>

</div>
</div>

<script src="<?=base_url('vendor/dataTables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#users',
  data: {
    currUserId: <?=$curr_user_id?>,
    users: <?=$users?>,
    profileUrl: "<?=base_url('dashboard/profile/')?>"
  },

  mounted() {
    $('#tblUsers').dataTable()
  },

  methods: {
    changeType(user) {
      // toggle type
      const oldType = user.type
      user.type = user.type == 1 ? 0 : 1
      // send ajax and update user type
      this._ajax({
        'id': user.id,
        'type': user.type
      }, function(res) {
        
      }, function() {
        user.type = oldType
      })
    },

    changeStatus(user) {
      // toggle status
      const oldStatus = user.status
      user.status = user.status == 1 ? 0 : 1
      // send ajax and update user status
      this._ajax({
        'id': user.id,
        'status': user.status
      }, function(res) {
        
      }, function() {
        user.status = oldStatus
      })
    },

    _ajax(data, successCallback, errorCallback) {
      // ajax
      const self = this
      $.ajax({
        'method': 'POST',
        'url': '<?=base_url('admin/update')?>',
        'dataType': 'JSON',
        'data': data,
        'success': successCallback,
        'error': errorCallback
      })
    }

  }
})

</script>