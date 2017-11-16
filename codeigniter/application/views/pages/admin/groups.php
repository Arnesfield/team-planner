<div id="groups">

<h3>Groups</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<table id="tblGroups" style="display: none" v-show="true">
  <thead>
    <tr>
      <th>Group ID</th>
      <th>Image</th>
      <th>Name</th>
      <th>Description</th>
      <th>No. of Members</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr :key="group.id" v-for="group in groups">
      <td>{{ group.id }}</td>
      <td>
        <template v-if="group.g_image">
          <img style="width: 52px; margin: 0 auto; display: block"
            :src="'<?=base_url('uploads/images/groups/')?>' + group.g_image" :alt="'img-' + group.id"/>
        </template>
        <template v-else>No image</template>
      </td>
      <td>{{ group.name }}</td>
      <td>{{ group.g_desc }}</td>
      <td>{{ group.member_count }}</td>
      <td>
        <input type="checkbox"
          :id="'status-' + group.id" :checked="group.status == 1" @click="changeStatus(group)">
        <label :for="'status-' + group.id">
          {{
          group.status == 1
            ? 'Activated'
            : group.status == 2
              ? 'Hidden'
              : 'Deactivated'
          }}
        </label>
      </td>
    </tr>
  </tbody>
</table>
</div>

</div>

<script src="<?=base_url('vendor/dataTables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#groups',
  data: {
    groups: <?=$groups?>,
  },

  mounted() {
    $('#tblGroups').dataTable()
  },

  methods: {
    changeType(group) {
      // toggle type
      const oldType = group.type
      group.type = group.type == 1 ? 0 : 1
      // send ajax and update group type
      this._ajax({
        'gid': group.id,
        'type': group.type
      }, function(res) {
        
      }, function() {
        group.type = oldType
      })
    },

    changeStatus(group) {
      // toggle status
      const oldStatus = group.status
      group.status = group.status == 1 ? 0 : 1
      // send ajax and update group status
      this._ajax({
        'gid': group.id,
        'status': group.status
      }, function(res) {
        
      }, function() {
        group.status = oldStatus
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