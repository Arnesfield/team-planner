<div id="contents">

<h3>Manage Content</h3>

<div v-cloak class="container-fluid">

<noscript>You need JavaScript to see the data.</noscript>

<div style="display: none" v-show="true">
  <form @submit.prevent="submit">
    <div class="my-mb-4">
      <button type="submit">Commit Content Changes</button>
      <a @click="addSection">Add Section</a>
    </div>

    <div :key="content.id" v-for="content in contents">
      <div class="row">

        <div class="col-md-3">
          <label :for="'title-' + content.id">Title</label>
          <input :id="'title-' + content.id" type="text" v-model="content.title"
            class="w-max" placeholder="Enter title">
        </div>
        <div class="col-md-6">
          <label :for="'content-' + content.id">Content</label>
          <br>
          <textarea :id="'content-' + content.id" rows="7" v-model="content.content"
            class="t-area" placeholder="Enter content"></textarea>
        </div>
        <div class="col-md-3">
          <div><strong>Actions</strong></div>
          <br>
          <!-- status -->
          <div>
            <input type="checkbox"
              :id="'status-' + content.id" :checked="content.status == 1" @click="changeStatus(content)">
            <label :for="'status-' + content.id">
              {{
              content.status == 1
                ? 'Activated'
                : content.status == 2
                  ? 'Hidden'
                  : 'Removed'
              }}
            </label>
          </div>

          <!-- type -->
          <div>
            <input type="radio" name="type"
              :id="'type-' + content.id" v-model="primary" :value="content">
            <label :for="'type-' + content.id">
              {{
              content.type == 1
                ? 'Primary'
                : content.type == 2
                  ? 'Set as Primary'
                  : 'Other'
              }}
            </label>
          </div>

        </div>
        <!-- end of col -->
      </div>
      <!-- end of row -->

    </div>
  </form>
</div>
</div>

</div>

<script src="<?=base_url('vendor/summernote/summernote.min.js')?>"></script>
<script src="<?=base_url('vendor/vue/vue.js')?>"></script>

<script>
new Vue({
  el: '#contents',
  data: {
    contents: <?=$contents?>,
    contentUrl: "<?=base_url('admin/content')?>",
    primary: null,
    workaround: true
  },

  watch: {
    primary(to, from) {
      if (from !== null && to !== from) {
        if (this.workaround) {
          this.changeType(to, from)
        }
        else {
          this.workaround = true
        }
      }
    }
  },

  created() {
    this.contents.every(e => {
      if (e.type == 1) {
        this.primary = e
        return false
      }
      return true
    })
  },

  mounted() {
    const self = this
    this.contents.forEach(e => {

      $(document).ready(function() {
        $('#content-' + e.id).summernote({
          callbacks: {
            onChange: function(contents) {
              e.content = contents
            }
          }
        })
      })
      
    })
  },

  methods: {
    addSection() {
      const self = this
      this.contents.push({
        title: "",
        content: "",
        id: String(self.contents.length + 1),
        status: "1",
        type: "2"
      })
    },

    submit() {
      // ajax
      const self = this
      const error = function() {
        alert('Unable to update changes.')
      }
      this._ajax({
        'action': 'submit',
        'contents': self.contents
      }, function(res) {
        if (res.success != 0) {
          window.location = self.contentUrl
        }
        else {
          error()
        }
      }, error)
    },

    setPrimary(content) {
      if (content.type == 1) {
        this.primary = content.id
      }
      return true
    },

    changeType(to, from) {
      // toggle type
      const oldToType = to.type
      const oldFromType = from.type

      to.type = to.type == 1 ? 2 : 1
      from.type = from.type == 1 ? 2 : 1
      // send ajax and update content type
      const self = this

      const error = function() {
        to.type = oldToType
        from.type = oldFromType
        self.workaround = false
        self.primary = from
      }

      this._ajax({
        'action': 'type',
        'to': {
          'cid': to.id,
          'type': to.type,
        },
        'from': {
          'cid': from.id,
          'type': from.type,
        }
      }, function(res) {
        if (res.success == 0) {
          error()
        }
      }, error)
    },

    changeStatus(content) {
      // toggle status
      const oldStatus = content.status
      content.status = content.status == 1 ? 0 : 1
      // send ajax and update content status
      const error = function() {
        content.status = oldStatus
      }
      this._ajax({
        'action': 'status',
        'cid': content.id,
        'status': content.status
      }, function(res) {
        if (res.success == 0) {
          error()
        }
      }, error)
    },

    _ajax(data, successCallback, errorCallback) {
      // ajax
      const self = this
      $.ajax({
        'method': 'POST',
        'url': '<?=base_url('admin/content_update')?>',
        'dataType': 'JSON',
        'data': data,
        'success': successCallback,
        'error': errorCallback
      })
    }

  }

})

</script>