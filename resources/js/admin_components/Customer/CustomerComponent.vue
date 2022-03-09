<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <h1>Profile</h1>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>

    <div class="card card-primary">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h3><i class="fas fa-user"></i>{{ customer.name }}</h3>
          <small>Customer</small>
        </li>
        <li class="list-group-item">
          <strong><i class="fas fa-map-marker"></i> Address</strong>
          <p>{{ customer.address }}</p>
        </li>
        <li class="list-group-item">
          <strong><i class="fas fa-phone"></i> Phone</strong>
          <p>{{ customer.phone }}</p>
        </li>
        <li class="list-group-item">
          <strong><i class="fas fa-envelope-open"></i> Email</strong>
          <p>{{ customer.email }}</p>
        </li>
        <li class="list-group-item">
          <strong class="row"
            ><div class="col-md-3">
              <i class="fas fa-money-bill"></i> Total paid
            </div>
            <div class="col-md-3">
              <i class="fas fa-users"></i>Member
            </div></strong
          >
          <div class="row">
            <p class="col-md-3">${{ customer.total_money }}</p>
            <p class="col-md-3">{{ customer.customer_group["group_name"] }}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="card card-primary mt-3">
      <datatable
        title="List Order"
        :columns="tableColumns1"
        :rows="orders"
        :perPage="[5, 10]"
      >
        <th style="width: 80px" slot="thead-tr">&nbsp;</th>
        <template slot="tbody-tr" slot-scope="props">
          <td>
            <button
              class="btn btn-primary btn-sm"
              @click="showModal(props.row['id'])"
            >
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </template>
      </datatable>
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
                    >Date:{{format_date(selectedOrder["created_at"])}}
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
                      <td>{{detail.get_product.product.name}}</td>
                      <td>{{detail.quantity}}</td>
                      <td>{{detail.get_product.product.price}}</td>
                      <td>${{detail.get_product.product.price*detail.quantity}}</td>
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
                      <td>%{{ discount }}</td>
                    </tr>
                    <tr>
                      <th>Total:</th>
                      <td>${{total_money}}</td>
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
import DataTable from "vue-materialize-datatable";
import Modal from "../../components/Modal.vue";

export default {
  data() {
    return {
      isModalVisible: false,
      total_money: 0,
      discount:0,
      customer: {},
      orders: [],
      selectedOrder: {},
      order_details: [],
      tableColumns1: [
        {
          label: "OrderID",
          field: "id",
          numeric: false,
          html: false,
        },
        {
          label: "Tổng tiền",
          field: "price",
          numeric: false,
          html: false,
        },
        {
          label: "Nhân viên bán",
          field: "user.name",
          numeric: false,
          html: false,
        },
        {
          label: "Mua tại",
          field: "user.store.name",
          numeric: false,
          html: false,
        },
        {
          label: "Ngày",
          field: "created_at",
          numeric: false,
          html: false,
        },
      ],
    };
  },
  created() {
    let uri = `http://127.0.0.1:8000/admin/customers/info/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
      this.customer = response.data;
      console.log(this.customer);
    });
    uri = `http://127.0.0.1:8000/admin/customers/order-list/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
      this.orders = response.data;
      console.log(this.orders);
    });
  },
  computed: {},
  methods: {
    showModal(id) {
      let index = this.orders.findIndex((x) => x.id == id);
      this.order_details = this.orders[index].order_details;
      this.total_money = this.orders[index].price;
      this.discount = this.orders[index].discount;
      this.selectedOrder = this.orders[index];
      console.log(this.discount);
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
    datatable: DataTable,
    Modal,
  },
};
</script>