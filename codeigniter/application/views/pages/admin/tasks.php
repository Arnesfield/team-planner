<div class="content">
<div class="pad">

<div id="tasks">

<h3>Tasks</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<table id="tblTasks" style="display: none" v-show="true">
  <thead>
    <tr>
      <th>Task ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Created By</th>
      <th>Created For</th>
      <th>Created At</th>
      <th>Deadline At</th>
      <th>Started At</th>
      <th>Ended At</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr :key="task.id" v-for="task in tasks">
      <td>{{ task.id }}</td>
      <td>{{ task.name }}</td>
      <td>{{ task.description }}</td>
      <td>{{ task.created_by_user_id }}</td>
      <td>{{ task.taken_by_user_id }}</td>
      <td>
        <span style="display: none">{{ task.raw_created_at }}</span>
        {{ task.created_at }}
      </td>
      <td>
        <span style="display: none">{{ task.raw_deadline_at }}</span>
        {{ task.deadline_at }}
      </td>
      <td>
        <span style="display: none">{{ task.raw_started_at }}</span>
        {{ task.started_at }}
      </td>
      <td>
        <span style="display: none">{{ task.raw_ended_at }}</span>
        {{ task.ended_at }}
      </td>
      <td>{{ task.status }}</td>
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
  el: '#tasks',
  data: {
    tasks: <?=$tasks?>,
  },

  mounted() {
    $('#tblTasks').dataTable()
  },

})

</script>