<template>
  <div class="col-md-12">
    <div class="card mt-3">
      <div class="card-header">
        <h3 class="card-title col-md-2">Kho</h3>
        <select class="form-select" v-model="selectedStore" @change="changeStore">
        <option value="0">Tất cả</option>
        <option v-for="store in stores" v-bind:value="store.id">
          {{ store.name }}
        </option>
      </select>
      </div>
      <div class="card-body">
          <table id="example" class="display nowrap" cellspacing="0" width="100%">
      <thead>
        <tr>
          <td>Sản phẩm</td>
          <td>Giá nhập</td>
          <td>Giá bán</td>
          <td>Số lượng</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="warehouse in warehousesCopy" :key="warehouse.id">
          <td>{{ warehouse.product.name }}</td>
          <td>{{ warehouse.product.price }}</td>
          <td>{{ warehouse.product.import_price }}</td>
          <td>
            {{ warehouse.quantity }}
          </td>
        </tr>
      </tbody>
    </table>
      </div>
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
      warehouses: [],
      users: [],
      stores: [],
      warehousesCopy: [],
      selectedStore: 0,
    };
  },
  created() {
    // let uri = "http://127.0.0.1:8000/admin/stores/list";
    // this.axios.get(uri).then((response) => {
    //   this.stores = response.data;
    // });
  },
  mounted() {
    fetch("http://127.0.0.1:8000/admin/warehouses/get-products")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.warehouses = data[0];
        this.warehousesCopy = this.warehouses;
        this.stores = data[1];

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
        let index = this.stores.findIndex((x) => x.id == this.selectedStore);
        this.warehousesCopy = this.stores[index].warehouses;
        // this.warehousesCopy = this.stores.warehouses.filter(
        //   (x) => x.store_id == this.selectedStore
        // );
      }else{
        this.warehousesCopy = this.warehouses;
      }
    },
  },
};
</script>