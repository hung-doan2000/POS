<template>
  <div>
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">CUSTOMER GROUP</h3>
      </div>
      <table id="example" class="display nowrap table" width="100%">
        <thead>
          <tr>
            <td>Id</td>
            <td>Group Name</td>
            <td>Condition</td>
            <td>Discount</td>
            <td>&nbsp;</td>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="customer_group in customer_groups"
            :key="customer_group['id']"
          >
            <td>{{ customer_group.id }}</td>
            <td>{{ customer_group.group_name }}</td>
            <td>${{ customer_group.condition }}</td>
            <td>%{{ customer_group.discount }}</td>
            <td>
              <button
                class="btn btn-primary"
                @click="showModal(customer_group['id'])"
              >
                <i class="fas fa-edit"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Modal v-show="isModalVisible" @close="closeModal">
      <div class="card-header" slot="header">
        <h3 class="card-title">Edit Customer Group</h3>
      </div>
      <div slot="body">
        <form @submit.prevent="editCustomerGroup()" >
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tên Nhóm</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nhập tên danh mục"
                    v-model="customer_group.group_name"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Điều kiện</label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="customer_group.condition"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Giảm giá (%)</label>
                  <input
                    type="float"
                    class="form-control"
                    v-model="customer_group.discount"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button class="btn btn-primary">Sửa</button>
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>

<script>
import "jquery/dist/jquery.min.js";
import "bootstrap/dist/css/bootstrap.min.css";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import Modal from "../../components/Modal.vue";
export default {
  data() {
    return {
      customer_groups: [],
      customer_group: {},
      isModalVisible: false,
      id:null,
    };
  },
  created() {},
  mounted() {
    fetch("http://127.0.0.1:8000/admin/customers/group")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.customer_groups = data;
        setTimeout(() => {
          $("#example").DataTable({
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
        });
      });
  },
  methods: {
    showModal(id) {
      this.id = id;
      let index = this.customer_groups.findIndex((x) => x.id == id);
      this.customer_group = this.customer_groups[index];
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    editCustomerGroup() {
      let uri = `http://127.0.0.1:8000/admin/customers/group-edit/${this.id}`;
      this.axios.post(uri, this.customer_group).then((response) => {
        this.customer_group = response.data;
        console.log(response.data)
        this.closeModal();
      });
    },
  },
  components: {
    Modal,
  },
};
</script>

