<div id="activities">

<h3>Activities</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<table id="tblActivities" style="display: none" v-show="true">
  <thead>
    <tr>
      <th>Activity ID</th>
      <th>Remarks</th>
      <th>Type</th>
      <th>Datetime</th>
    </tr>
  </thead>
  <tbody>
    <tr :key="activity.id" v-for="activity in activities">
      <td>{{ activity.id }}</td>
      <td>{{ activity.remarks }}</td>
      <td>{{ activity.type }}</td>
      <td>{{ activity.date }}</td>
    </tr>
  </tbody>
</table>
</div>

</div>

<script src="<?=base_url('vendor/dataTables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#activities',
  data: {
    activities: <?=$activities?>,
  },

  mounted() {
    $('#tblActivities').dataTable()
  },

})

</script>