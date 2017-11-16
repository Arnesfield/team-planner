<div id="memberships">

<h3>Memberships</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<table id="tblMemberships" style="display: none" v-show="true">
  <thead>
    <tr>
      <th>Membership ID</th>
      <th>User ID</th>
      <th>Username</th>
      <th>Group ID</th>
      <th>Group Name</th>
      <th>Membership Type</th>
      <th>Membership Status</th>
    </tr>
  </thead>
  <tbody>
    <tr :key="membership.id" v-for="membership in memberships">
      <td>{{ membership.id }}</td>
      <td>{{ membership.user_id }}</td>
      <td>{{ membership.username }}</td>
      <td>{{ membership.group_id }}</td>
      <td>{{ membership.group_name }}</td>
      <td>
        <input type="checkbox"
          :id="'type-' + membership.id" :checked="membership.type == 1" @click="changeType(membership)">
        <label :for="'type-' + membership.id">{{
          membership.type == 1 ? 'Admin' : 'Member'
        }}</span>
      </td>
      <td>
        <input type="checkbox"
          :id="'status-' + membership.id" :checked="membership.status == 1" @click="changeStatus(membership)">
        <label :for="'status-' + membership.id">
          {{
          membership.status == 1
            ? 'Joined'
            : membership.status == 2
              ? 'Invited'
              : 'Removed'
          }}
        </label>
      </td>
    </tr>
  </tbody>
</table>
</div>

</div>

<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#memberships',
  data: {
    memberships: <?=$memberships?>,
  },

  mounted() {
    $('#tblMemberships').dataTable()
  },

  methods: {
    changeType(membership) {
      // toggle type
      const oldType = membership.type
      membership.type = membership.type == 1 ? 2 : 1
      // send ajax and update membership type
      this._ajax({
        'mid': membership.id,
        'type': membership.type
      }, function(res) {
        
      }, function() {
        membership.type = oldType
      })
    },

    changeStatus(membership) {
      // toggle status
      const oldStatus = membership.status
      membership.status = membership.status == 1 ? 0 : 1
      // send ajax and update membership status
      this._ajax({
        'mid': membership.id,
        'status': membership.status
      }, function(res) {
        
      }, function() {
        membership.status = oldStatus
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