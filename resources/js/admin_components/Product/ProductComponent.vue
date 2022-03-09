<template>
  <div class="card card-primary mt-3">
    <div class="card-header">
      <h3 class="card-title">PRODUCT</h3>
      <router-link
        :to="{ name: 'products.create' }"
        type="button"
        class="btn btn-info btn-sm"
        style="float: right"
      >
        Create new Product
      </router-link>
    </div>
    <br>
    <table id="example" class="display nowrap table" width="100%">
      <thead>
        <tr>
          <td>Id</td>
          <td>Name</td>
          <td>Category</td>
          <td>Brand</td>
          <td>Giá bán</td>
          <td>Giá nhập</td>
          <td>Active</td>
          <td>Photo</td>
          <td>&nbsp;</td>
        </tr>
      </thead>
      <tbody v-if="loaded">
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.category.name }}</td>
          <td>{{ product.brand.name }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.import_price }}</td>
          <td>
            <span v-if="product['active'] == 0" class="btn btn-danger btn-xs"
              >NO</span
            >
            <span v-if="product['active'] != 0" class="btn btn-success btn-xs"
              >YES</span
            >
          </td>
          <td>
            <img class="img-thumbnail" width="60px" :src="product['photo']" />
          </td>
          <td>
            <router-link
              :to="{ name: 'products.edit', params: { id: product['id'] } }"
              class="btn btn-primary btn-sm"
            >
              <i class="fas fa-edit"></i>
            </router-link>
            <a class="btn btn-danger btn-sm" @click="showModal(product.id)">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <Modal v-show="isModalVisible" @close="closeModal">
      <div class="card-header" slot="header">
        <h3 class="card-title">Delete Product</h3>
      </div>
      <div class="card-body" slot="body">Bạn có muốn xóa Product này?</div>
      <div class="card-footer" slot="footer">
        <button class="modal-default-button btn-warning" @click="deleteProd()">
          Delete
        </button>
        <button class="modal-default-button btn-error" @click="closeModal">
          Exit
        </button>
      </div>
    </Modal>
  </div>
</template>

<script>
import Modal from "../../components/Modal.vue";
import "jquery/dist/jquery.min.js";
import "bootstrap/dist/css/bootstrap.min.css";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

export default {
  data() {
    return {
      product: {},
      products: [],
      isModalVisible: false,
      id: null,
      loaded: false,
      data: null,
    };
  },
  mounted() {
    // fetch("http://127.0.0.1:8000/admin/products/list")
    //   .then((response) => response.json())
    //   .then((data) => {
    //     console.log(data);
    //     this.products = data;
    //     setTimeout(() => {
    //       $("#example").DataTable({
    //         order: [
    //           [0, "asc"],
    //           [3, "desc"],
    //         ],
    //         responsive: true,
    //         destroy: true,
    //         retrieve: true,
    //         autoFill: true,
    //         colReorder: true,
    //         buttons: ["copy", "excel", "pdf"],
    //       });
    //     },300);
    //     this.loaded = true;
    //   });
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/products/list";
    this.axios.get(uri).then((response) => {
      this.products = response.data;
      setTimeout(() => {
        this.data = $("#example").DataTable({
          order: [
            [0, "asc"],
            [3, "desc"],
          ],

          responsive: true,
          destroy: true,
          retrieve: true,
          autoFill: true,
          colReorder: true,
          buttons: ["copy", "excel", "pdf"],
        });
      }, 300);
      this.loaded = true;
    });
  },
  computed: {},
  methods: {
    displayPrs() {},
    showModal(index) {
      this.id = index;
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    deleteProd() {
      this.loaded = false;
      try {
        let uri = `http://127.0.0.1:8000/admin/products/delete-prod/${this.id}`;
        this.axios.delete(uri).then((response) => {
          console.log(response.data);
          this.products = response.data;
          this.data.destroy();

          //this.products.push(this.category);
          // let index = this.products.findIndex((x) => x.id == this.id);
          // this.products.splice(this.products.indexOf(index), 1);
          // console.log(index)
          this.isModalVisible = false;
          setTimeout(() => {
            this.data = $("#example").DataTable({
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
          }, 300);
        });
      } catch (error) {
        console.error(error.response.data); // NOTE - use "error.response.data` (not "error")
      }
      this.loaded = true;
    },
  },
  components: {
    Modal,
  },
};
</script>


