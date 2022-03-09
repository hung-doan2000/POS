<template>
  <section class="section-content padding-y-sm bg-default">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 card padding-y-sm card">
          <ul class="nav bg radius nav-pills nav-fill mb-3 bg" role="tablist">
            <li class="nav-item">
              <button
                class="btn nav-link active show"
                data-toggle="pill"
                @click.prevent="selectCate(0)"
              >
                <i class="fa fa-tags"></i> All
              </button>
            </li>
            <li
              class="nav-item"
              v-for="category in categories"
              :key="category['id']"
            >
              <button
                class="btn nav-link"
                data-toggle="pill"
                @click.prevent="selectCate(category['id'])"
              >
                <i class="fa fa-tags"></i> {{ category["name"] }}
              </button>
            </li>
          </ul>
          <span id="items">
            <div class="row">
              <div class="col-md-3" v-for="stock in stocks" :key="stock['id']">
                <figure class="card card-product">
                  <div class="img-wrap">
                    <img :src="stock['photo']" />
                  </div>
                  <figcaption class="info-wrap">
                    <a href="#" class="title">{{ stock["name"] }}</a>
                    <div class="action-wrap">
                      <button
                        @click.prevent="addToCart(stock['id'])"
                        class="btn btn-primary btn-sm float-right"
                      >
                        <i class="fa fa-cart-plus"></i> Add
                      </button>
                      <div class="price-wrap h5">
                        <span class="price-new">{{ stock["price"] }}</span>
                      </div>
                      <!-- price-wrap.// -->
                    </div>
                    <!-- action-wrap -->
                  </figcaption>
                </figure>
                <!-- card // -->
              </div>
              <!-- col // -->
            </div>
            <!-- row.// -->
          </span>
        </div>
        <div class="col-md-4">
          <div class="card">
            <table class="table ">
              <thead class="text-muted">
                <tr>
                  <th scope="col">Customer</th>
                  <th scope="col">New</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <model-select
                      :options="customers"
                      v-model="selected"
                      placeholder="select customer"
                    >
                    </model-select>
                  </td>
                  <td>
                    <div
                      class="m-btn-group m-btn-group--pill btn-group mr-2"
                      role="group"
                      aria-label="..."
                    >
                      <!-- <router-link :to="{ name: 'customer' }"
                        ><button type="button" class="m-btn btn btn-default">
                          <i class="fa fa-plus"></i></button
                      ></router-link> -->
                      <button type="button" class="btn" @click="showModal">
                        <i class="fa fa-plus"></i>
                      </button>

                      <!-- <b-button class="m-btn btn btn-default" v-b-modal.modal-prevent-closing><i class="fa fa-plus"></i></b-button> -->
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card">
            <span id="cart">
              <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-right">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="cart in carts" :key="cart['product_id']">
                    <td>
                      <!-- <figure class="media">
                        <div class="img-wrap">
                          <img
                            :src="cart['photo']"
                            class="img-thumbnail img-xs"
                          />
                        </div>
                      </figure> -->
                      {{cart.name}}
                    </td>
                    <td class="text-center">
                      <div
                        class="m-btn-group m-btn-group--pill btn-group mr-2"
                        role="group"
                        aria-label="..."
                      >
                        <button
                          type="button"
                          class="m-btn btn btn-default"
                          @click.prevent="minusCart(cart['product_id'])"
                        >
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="m-btn btn btn-default">
                          {{ cart["quantity"] }}
                        </button>
                        <button
                          type="button"
                          class="m-btn btn btn-default"
                          @click.prevent="addToCart(cart['product_id'])"
                        >
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </td>
                    <td>
                      <div class="price-wrap">
                        <var class="price">${{ cart["price"] }}</var>
                      </div>
                      <!-- price-wrap .// -->
                    </td>
                    <td>
                      <div class="price-wrap">
                        <var class="price"
                          >${{ cart["price"] * cart["quantity"] }}</var
                        >
                      </div>
                      <!-- price-wrap .// -->
                    </td>
                    <td class="text-right">
                      <button
                        class="btn btn-outline-danger"
                        @click.prevent="removeCart(cart['product_id'])"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </span>
          </div>
          <!-- card.// -->
          <div class="box">
            <dl class="dlist-align">
              <dt>Discount:</dt>
              <dd class="text-right"><a href="#">%{{ discount }}</a></dd>
            </dl>
            <dl class="dlist-align">
              <dt>Total:</dt>
              <dd class="text-right h4 b">${{ Total }}</dd>
            </dl>
            <div class="row">
              <div class="col-md-6">
                <button
                  @click.prevent="cancel()"
                  class="btn btn-default btn-error btn-lg btn-block"
                >
                  <i class="fa fa-times-circle"></i> Cancel
                </button>
              </div>
              <div class="col-md-6">
                <button
                  @click.prevent="charge(selected['value'])"
                  class="btn btn-primary btn-lg btn-block"
                >
                  <i class="fa fa-shopping-bag"></i> Charge
                </button>
              </div>
            </div>
          </div>
          <!-- box.// -->
        </div>
      </div>
    </div>
    <Modal v-show="isModalVisible" @close="closeModal">
      <h3 slot="header">Add new customer</h3>
      <div slot="body">
        <div class="container-fluid">
          <form @submit.prevent="addCustomer">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tên khách hàng</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="customer.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Số điện thoại</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="customer.phone"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="customer.email"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Địa chỉ</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="customer.address"
                    />
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      -
    </Modal>

    <!-- container //  -->
  </section>
</template>

<script>
import { ModelSelect } from "vue-search-select";
import Modal from "./Modal.vue";

export default {
  data() {
    return {
      discount: 0,
      stocks: [],
      categories: [],
      carts: [],
      results: [],
      customers: [],
      customers_list:[],
      customer: {},
      selected: {
        value: "",
        text: "",
      },
      isModalVisible: false,
    };
  },
  watch: {
    selected(newVal,oldVal){
      let index = this.customers_list.findIndex((x) => x.id == newVal.value);
      this.discount = this.customers_list[index].customer_group.discount;
    }
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/orders/index";
    this.axios.get(uri).then((response) => {
      this.stocks = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/orders/cate";
    this.axios.get(uri).then((response) => {
      this.categories = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/orders/cart";
    this.axios.get(uri).then((response) => {
      this.carts = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/customers/index";
    this.axios.get(uri).then((response) => {
      this.customers = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/customers/list";
    this.axios.get(uri).then((response) => {
      this.customers_list = response.data;
      console.log(this.customers_list)
    });
  },
  computed: {
    Total() {
      let total = 0;
      for (let i = 0; i < this.carts.length; i++) {
        total += this.carts[i].price * this.carts[i].quantity;
      }
      total = total - total*this.discount/100;
      return total;
    },
  },
  methods: {
    selectCate(id) {
      if (id != 0) {
        let uri = `http://127.0.0.1:8000/admin/orders/select-cate/${id}`;
        this.axios.get(uri).then((response) => {
          this.stocks = response.data;
        });
      } else {
        let uri = "http://127.0.0.1:8000/admin/orders/index";
        this.axios.get(uri).then((response) => {
          this.stocks = response.data;
        });
      }
    },
    addToCart(id) {
      let uri = `http://127.0.0.1:8000/admin/orders/add-to-cart-pos/${id}`;
      this.axios.get(uri).then((response) => {
        this.carts = response.data;
      });
    },
    minusCart(id) {
      let uri = `http://127.0.0.1:8000/admin/orders/minus-cart/${id}`;
      this.axios.get(uri).then((response) => {
        this.carts = response.data;
      });
    },
    removeCart(id) {
      let uri = `http://127.0.0.1:8000/admin/orders/remove-cart/${id}`;
      this.axios.get(uri).then((response) => {
        this.carts = response.data;
      });
    },
    charge(id) {
      window.open("/admin/orders/print", "_blank");
      let uri = `http://127.0.0.1:8000/admin/orders/charge-cart/${id}`;
      this.axios.get(uri).then((response) => {
        console.log(response)
        this.carts = [];
      });
    },
    cancel() {
      let uri = `http://127.0.0.1:8000/admin/orders/cancel-cart`;
      this.axios.delete(uri).then((response) => {});
      this.carts = [];
    },
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    addCustomer() {
      console.log(this.customer);
      let uri = "http://127.0.0.1:8000/admin/customers/store";
      this.axios.post(uri, this.customer).then((response) => {
        let newCustomer = response.data;
        console.log(this.customers);
        this.customers.push(newCustomer);
      });

      this.closeModal();
    },
  },
  components: {
    ModelSelect,
    Modal,
  },
};
</script>
