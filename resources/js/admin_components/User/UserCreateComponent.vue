<template>
  <div class="card">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <h1>Profile</h1>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <form @submit.prevent="createUser" enctype="multipart/form-data">
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
              <input type="text" v-model="user.phone" class="form-control" />
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="birthday">Ngày sinh</label>
          <input type="date" v-model="user.birthday" class="form-control" />
        </div>
        <div class="form-group">
          <label for="upload">Ảnh</label>
          <input type="file" class="form-control"  v-on:change="onChange" />
          <div id="image_show">
            <a href="" target="_blank">
              <img :src="user.photo" width="100px" />
            </a>
          </div>
          <input type="hidden" id="photo" value="" name="photo" />
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Vai trò</label>
            <select v-model="role_id" class="form-control select2" style="width: 50%">

              <option v-for="role in roles" v-bind:value="role.id" >{{ role.name }}</option>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Cửa hàng</label>
            <select
              v-model="user.store_id"
              class="form-control select2"
              style="width: 50%"
            >
              <option v-for="store in stores" v-bind:value="store.id" >{{ store.name }}</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user:{},
      stores:[],
      roles:[],
      role_id: null,
    };
  },
  created() {
    let uri = `http://127.0.0.1:8000/admin/stores/list`;
    this.axios.get(uri).then((response) => {
      this.stores = response.data;
      console.log(this.stores)
    });
    uri = `http://127.0.0.1:8000/admin/users/roles`;
    this.axios.get(uri).then((response) => {
      this.roles = response.data;
      console.log(this.roles)
    });
    
  },
  methods: {
    onChange(e) {
      this.user["photo"] = e.target.files[0];
    },
    createUser() {
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
      data.append("store_id", this.user["store_id"]);
      data.append("role_id", this.role_id);
      data.append("birthday", this.user["birthday"]);
      if (this.user.photo) {
        data.append("photo", this.user["photo"]);
      }
      console.log(data);

      let uri = `http://127.0.0.1:8000/admin/users/create-user`;
      this.axios
        .post(uri, data)
        .then((response) => {
            console.log(response.data)
          this.$router.push({ name: "user-list" });
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          }
          if (error.response.status === 403) {
            console.log(error.response)
            alert(error.response.data.message);
          }
        });
    },
  },
  components: {},
};
</script>
