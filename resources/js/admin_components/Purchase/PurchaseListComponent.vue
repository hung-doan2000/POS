<template>
  <div>
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">Purchase List</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm form-group">
            <label for="menu">Nhà cung cấp</label>
            <model-list-select
              :list="suppliers"
              v-model="selectedSupplier"
              option-value="id"
              option-text="name"
              placeholder="select supplier"
            >
            </model-list-select>
          </div>

          <div class="col-sm">
            <div class="form-group">
              <label for="menu">Cửa hàng nhập</label>
              <model-list-select
                :list="stores"
                v-model="selectedStore"
                option-value="id"
                option-text="name"
                placeholder="select store"
              >
              </model-list-select>
            </div>
          </div>
          <div class="col-sm">
            <div class="form-group">
              <label for="menu">Trạng thái</label>
              <model-select
                :options="optionPaid"
                v-model="selectPaid"
                placeholder="select status"
              >
              </model-select>
            </div>
          </div>
          <!-- <div class="col-sm">
            <div class="form-group">
              <label for="menu">Trạng thái nhập</label>
              <model-select
                :options="optionRecieved"
                v-model="selectRecieved"
                placeholder="select status"
              >
              </model-select>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="card mt-3 card-info">
      <div class="card-header">
        <h3 class="card-title">List</h3>
      </div>
      <div class="card-body">
        <table class="table text-center">
          <thead>
            <tr>
              <th>#</th>
              <th>Ngày tạo đơn</th>
              <th>Ngày thanh toán</th>
              <th>Nhà cung cấp</th>
              <th>Cửa hàng nhận</th>
              <th>Tổng</th>
              <th>Trạng thái</th>
              <th>Chi tiết</th>
              <!-- <th>Tình trạng nhập</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="(purchase, index) in cpPurchases" :key="index">
              <td>{{ purchase["id"] }}</td>
              <td>{{ format_date(purchase["created_at"]) }}</td>
              <td>
                <div v-if="purchase['paid'] == 1">
                  {{ format_date(purchase["updated_at"]) }}
                </div>
              </td>
              <td>{{ purchase["place_order"] }}</td>
              <td>{{ findStore(purchase["stock_id"]) }}</td>
              <td>${{ purchase["money"] }}</td>
              <td>
                <button
                  v-if="purchase['paid'] == 0"
                  class="btn btn-danger"
                  @click.prevent="showModal(index)"
                >
                  Chưa thanh toán
                </button>
                <span v-if="purchase['paid'] != 0" class="btn btn-success"
                  >Đã thanh toán</span
                >
              </td>
              <td>
                <button
                  class="btn btn-primary btn-sm"
                  @click="showDetail(purchase['id'])"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </td>
              <!-- <td>
                <button v-if="purchase['status'] == 0" class="btn btn-danger">
                  Chưa nhập
                </button>
                <span v-if="purchase['status'] != 0" class="btn btn-success"
                  >Đã nhập</span
                >
              </td> -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <PurchasePayment
      v-show="isModalPurchase"
      :purchase="purchase"
      @close="closeModal()"
      @pay="handlePay"
    >
    </PurchasePayment>
    <Modal v-show="isModalVisible" @close="closeDetail">
      <div class="card-header" slot="header">
        <h3 class="card-title">Thông tin đơn</h3>
      </div>
      <div slot="body">
        <div class="card-body">
          <table class="table text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Sản phẩm</th>
                <th>Giá nhập</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(detail, index) in details" :key="index">
                <td>{{ detail["id"] }}</td>
                <td>{{ detail.product.name }}</td>
                <td>
                  {{ detail.product.import_price }}
                </td>
                <td>{{ detail["quantity"] }}</td>
                <td>{{ detail["money"] }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script>
import { ModelSelect, ModelListSelect } from "vue-search-select";
import moment from "moment";
import PurchasePayment from "./PurchasePayment.vue";
import Modal from "../../components/Modal.vue";

export default {
  data() {
    return {
      isModalVisible: false,
      details: [],
      index: 0,
      submit: 0,
      isModalPurchase: false,
      purchases: [],
      purchase: {},
      cpPurchases: [],
      suppliers: [],
      selectedSupplier: { id: 0, name: "Tất cả" },
      stores: [],
      selectedStore: { id: 0, name: "Tất cả" },
      user: {},
      optionRecieved: [
        { value: "0", text: "Chưa nhập" },
        { value: "1", text: "Đã nhập" },
        { value: "2", text: "Tất cả" },
      ],
      selectRecieved: { value: "2", text: "Tất cả" },
      optionPaid: [
        { value: "0", text: "Chưa thanh toán" },
        { value: "1", text: "Đã thanh toán" },
        { value: "2", text: "Tất cả" },
      ],
      selectPaid: { value: "2", text: "Tất cả" },
    };
  },
  computed: {},
  watch: {
    purchase(newVal, oldVal) {},
    selectedSupplier(newVal, oldVal) {
      this.filterPurchase(
        newVal,
        this.selectedStore,
        this.selectRecieved,
        this.selectPaid
      );
    },
    selectedStore(newVal, oldVal) {
      this.filterPurchase(
        this.selectedSupplier,
        newVal,
        this.selectRecieved,
        this.selectPaid
      );
    },
    selectPaid(newVal, oldVal) {
      this.filterPurchase(
        this.selectedSupplier,
        this.selectedStore,
        this.selectRecieved,
        newVal
      );
    },
    selectRecieved(newVal, oldVal) {
      this.filterPurchase(
        this.selectedSupplier,
        this.selectedStore,
        newVal,
        this.selectPaid
      );
    },
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/suppliers/list";
    this.axios.get(uri).then((response) => {
      this.suppliers = response.data;
      this.suppliers.push({ id: 0, name: "Tất cả" });
    });
    uri = "http://127.0.0.1:8000/admin/stores/list";
    this.axios.get(uri).then((response) => {
      this.stores = response.data;
      this.stores.push({ id: 0, name: "Tất cả" });
    });
    uri = "http://127.0.0.1:8000/admin/purchases/list";
    this.axios.get(uri).then((response) => {
      this.purchases = response.data;
      this.cpPurchases = this.purchases;
    });
  },
  methods: {
    handlePay(data) {
      console.log(data);
      this.purchases[this.index] = data;
      this.closeModal();
    },
    showModal(index) {
      this.index = index;
      this.purchase = this.purchases[index];
      this.isModalPurchase = true;
    },
    closeModal() {
      this.isModalPurchase = false;
    },
    resetSelectedProduct() {
      this.selectedProduct = {};
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("MM/DD/YYYY hh:mm");
      }
    },
    findStore(id) {
      let index = this.stores.findIndex((x) => x.id == id);
      return this.stores[index].name;
    },
    filterPurchase(sup, store, receive, paid) {
      this.cpPurchases = this.purchases;
      if (sup.name.localeCompare("Tất cả") != 0) {
        this.cpPurchases = this.cpPurchases.filter(
          (x) => x.place_order == sup.name
        );
      }
      if (store.id > 0) {
        this.cpPurchases = this.cpPurchases.filter(
          (x) => x.stock_id == store.id
        );
      }
      if (receive.value != 2) {
        this.cpPurchases = this.cpPurchases.filter(
          (x) => x.status == receive.value
        );
      }
      if (paid.value != 2) {
        this.cpPurchases = this.cpPurchases.filter((x) => x.paid == paid.value);
      }
    },
    showDetail(id) {
      let uri = `http://127.0.0.1:8000/admin/purchases/details/${id}`;
      this.axios.get(uri).then((response) => {
        console.log(response.data);
        this.details = response.data;
        this.isModalVisible = true;
      });
      
    },
    closeDetail() {
      this.isModalVisible = false;
    },
  },
  components: {
    ModelSelect,
    ModelListSelect,
    moment,
    PurchasePayment,
    Modal,
  },
};
</script>
