<template>
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title col-md-2">USER</h3>
      <select class="form-select" v-model="selectedStore" @change="changeStore">
        <option value="0">Tất cả</option>
        <option v-for="store in stores" v-bind:value="store.id">
          {{ store.name }}
        </option>
      </select>
      <router-link :to="{name:'user-create'}" type="button" class="btn btn-info btn-sm" style="float: right">
        New User
      </router-link>
    </div>
    <div class="card-body">
    <table id="example" class="display nowrap" cellspacing="0" width="100%">
      <thead>
        <tr>
          <td>Avatar</td>
          <td>ID</td>
          <td>Tên nhân viên</td>
          <td>Email</td>
          <td>Cửa hàng</td>
          <td>Vai trò</td>
          <td style="width: 100px">&nbsp;</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in usersCopy" :key="user.id">
          <td>
            <img
              class="img-thumbnail"
              width="120px"
              :src="user.photo"
            />
          </td>
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            {{ user.store.name }}
          </td>
          <td>{{ user.roles[0].name }}</td>
          <td>
            <router-link
              :to="{ name: 'user', params: { id: user.id } }"
              class="btn btn-primary btn-sm"
            >
              <i class="fas fa-eye"></i>
            </router-link>
            <button class="delete btn btn-danger btn-sm" data="">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </div>
</template>

<script>
import "jquery/dist/jquery.min.js";
import "bootstrap/dist/css/bootstrap.min.css";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
export default {
  data() {
    return {
      users: [],
      stores: [],
      usersCopy: [],
      selectedStore: 0,
    };
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/stores/list";
    this.axios.get(uri).then((response) => {
      this.stores = response.data;
    });
  },
  mounted() {
    fetch("http://127.0.0.1:8000/admin/users/list")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.users = data;
        if (this.$route.params.id) {
          this.selectedStore = this.$route.params.id;
          this.changeStore();
        } else {
          this.usersCopy = this.users;
        }

        setTimeout(() => {
          $("#example").DataTable({
            autoWidth: true,
            responsive: true,
            destroy: true,
            retrieve: true,
            autoFill: true,
            colReorder: true,
            buttons: ["copy", "excel", "pdf"],
          });
        },300);
      });
  },
  methods: {
    changeStore() {
      if (this.selectedStore != 0) {
        this.usersCopy = this.users.filter(
          (x) => x.store_id == this.selectedStore
        );
      }else {
          this.usersCopy = this.users
      }
    },
  },
};
</script>