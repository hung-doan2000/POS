<template>
  <div class="col-md-12">
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">STORE</h3>
      </div>
      <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <td>ID</td>
            <td>Tên Cửa Hàng</td>
            <td>Địa Chỉ</td>
            <td>Số Điện Thoại</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="store in stores" :key="store.id">
            <td>{{ store.id }}</td>
            <td>{{ store.name }}</td>
            <td>{{ store.address }}</td>
            <td>{{ store.phone }}</td>
            <td>
              <router-link :to="{ name: 'warehouse' }"  class="btn btn-primary" >Kho</router-link>
              <router-link
                :to="{ name: 'user-list', params: { id: store.id } }"
                class="btn btn-primary"
              >
                Nhân viên
              </router-link>
            </td>
            <!-- <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                <a
                  
                  class="btn btn-primary "
                >
                  <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="delete btn btn-danger">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td> -->
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
      stores: [],
    };
  },
  mounted() {
    fetch("http://127.0.0.1:8000/admin/stores/list")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.stores = data;
        setTimeout(() => {
          $("#example").DataTable({
            order: [
              [0, "asc"],
              [3, "desc"],
            ],
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
};
</script>
