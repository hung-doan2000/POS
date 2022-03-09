<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <h1>Profile</h1>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img
                  class="profile-user-img img-fluid img-circle"
                  :src="user.photo"
                  alt="User profile picture"
                />
              </div>

              <h3 class="profile-username text-center">{{ user.name }}</h3>

              <p class="text-muted text-center">{{ user.roles[0].name }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Cửa hàng</b>
                  <a class="float-right">{{ user.store.name }}</a>
                </li>
                <li class="list-group-item">
                  <b>Sản phẩm bán</b> <a class="float-right">{{ quantity }}</a>
                </li>
                <li class="list-group-item">
                  <b>Doanh thu</b> <a class="float-right">${{ money }}</a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#info" data-toggle="tab"
                    >User Info</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#activity" data-toggle="tab"
                    >Activity</a
                  >
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="info">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <h3><i class="fas fa-user"></i>{{ user.name }}</h3>
                      <small>{{ user.roles[0].name }}</small>
                    </li>
                    <li class="list-group-item">
                      <strong><i class="fas fa-birthday-cake"></i> Sinh nhật </strong>
                      <p>{{ user.birthday }}</p>
                    </li>
                    <li class="list-group-item">
                      <strong><i class="fas fa-map-marker"></i> Địa chỉ </strong>
                      <p>{{ user.address }}</p>
                    </li>
                    <li class="list-group-item">
                      <strong
                        ><i class="fas fa-phone"></i> Số điện thoại</strong
                      >
                      <p>{{ user.phone }}</p>
                    </li>
                    <li class="list-group-item">
                      <strong
                        ><i class="fas fa-envelope-open"></i> Email</strong
                      >
                      <p>{{ user.email }}</p>
                    </li>
                    <li class="list-group-item">
                      <strong><router-link
                        :to="{ name: 'user-edit', params: {id: user.id} }"
                        class="btn btn-primary"
                      >
                        Sửa thông tin
                      </router-link>
                      </strong>
                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="activity">
                  <table id="example" class="display nowrap table" width="100%">
                    <thead>
                      <tr>
                        <td>Id</td>
                        <td>Ngày</td>
                        <td>Tổng đơn</td>
                        <td>&nbsp;</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.id }}</td>
                        <td>{{ format_date(order.created_at) }}</td>
                        <td>{{ order.price }}</td>
                        <td>
                          <button
                            class="btn btn-primary btn-sm"
                            @click="showModal(order.id)"
                          >
                            <i class="fas fa-eye"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
          </div>
        </div>
      </div>
    </div>
    <Modal v-show="isModalVisible" @close="closeModal">
      <div class="card-header" slot="header">
        <h3 class="card-title">Order Detail</h3>
      </div>
      <div slot="body">
        <div class="wrapper">
          <!-- Main content -->
          <section class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h2 class="page-header">
                  <i class="fas fa-globe"></i>RHUST, Inc.
                  <small class="float-right"
                    >Date:{{ format_date(selectedOrder["created_at"]) }}
                    <p></p>
                  </small>
                </h2>
              </div>
              <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="detail in order_details" :key="detail['id']">
                      <td>{{ detail.get_product.product.name }}</td>
                      <td>{{ detail.quantity }}</td>
                      <td>{{ detail.get_product.product.price }}</td>
                      <td>
                        ${{
                          detail.get_product.product.price * detail.quantity
                        }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->

              <!-- /.col -->
              <div class="col-6">
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th>Discount (0%)</th>
                      <td>$0</td>
                    </tr>
                    <tr>
                      <th>Total:</th>
                      <td>${{ total_money }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script>
import moment from "moment";
import "jquery/dist/jquery.min.js";
import "bootstrap/dist/css/bootstrap.min.css";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import Modal from "../../components/Modal.vue";

export default {
  data() {
    return {
      isModalVisible: false,
      total_money: 0,
      user: {},
      orders: [],
      info: [],
      quantity: 0,
      money: 0,
      selectedOrder: {},
      order_details: [],
    };
  },
  mounted() {
    let uri = `http://127.0.0.1:8000/admin/users/info/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
      this.info = response.data;
      this.user = this.info[0];
      this.money = parseFloat(this.info[1]).toFixed(2);
      this.quantity = this.info[2];
      this.orders = this.info[3];
      setTimeout(() => {
        $("#example").DataTable({
          responsive: true,
          destroy: true,
          retrieve: true,
          autoFill: true,
          colReorder: true,
          buttons: ["copy", "excel", "pdf"],
        });
      }, 500);
      console.log(this.info);
    });
  },
  created() {},
  methods: {
    showModal(id) {
      let index = this.orders.findIndex((x) => x.id == id);
      console.log(index);
      this.order_details = this.orders[index].order_details;
      this.total_money = this.orders[index].price;
      console.log(this.order_details);
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("MM/DD/YYYY hh:mm");
      }
    },
  },
  components: {
    Modal,
  },
};
</script>
