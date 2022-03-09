<template>
  <div class="col-md-12">
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">Chỉnh sửa thông tin</h3>
      </div>
      <form @submit.prevent="edit" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label>Tên người dùng</label>
            <input type="text" v-model="user.name" class="form-control" />
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
                <input type="text" v-model="user.email" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" v-model="user.phone" value="" class="form-control" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="birthday">Ngày sinh</label>
            <input type="date" v-model="user.birthday" class="form-control" />
          </div>
          <div class="form-group">
            <label for="upload">Ảnh đại diện</label>
            <input type="file" class="form-control" v-on:change="onChange" />
            <div id="image_show">
              <a href="" target="_blank">
                <img v-if="user.photo" :src="user.photo" width="100px" />
              </a>
            </div>
            <input type="hidden" id="photo" value="" name="photo" />
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user:{},
    };
  },
  created() {
    let uri = `http://127.0.0.1:8000/admin/users/info/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
      this.user = response.data[0];
      console.log(this.user)
    });
    
  },
  methods: {
    onChange(e) {
      this.user["photo"] = e.target.files[0];
    },
    edit() {
      const data = new FormData();
      if (this.user.name) {
        data.append("name", this.user["name"]);
      }
      if (this.user.email) {
        data.append("email", this.user["email"]);
      }
      if (this.user.phone) {
        data.append("phone", this.user["phone"]);
      }
      data.append("birthday", this.user["birthday"]);
      data.append("photo", this.user["photo"]);
      console.log(data);

      let uri = `http://127.0.0.1:8000/admin/users/edit-info/${this.$route.params.id}`;
      this.axios
        .post(uri, data)
        .then((response) => {
          this.$router.push({ name: "dashboard" });
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          }
        });
    },
  },
  components: {},
};
</script>
