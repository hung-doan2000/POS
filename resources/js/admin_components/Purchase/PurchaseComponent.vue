<template>
  <div>
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">Purchase</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm form-group">
            <label for="menu">Nhà cung cấp</label>
            <table class="col-md-12">
              <tr>
                <td class="col-md-11">
                  <!-- <model-select :options="suppliers" v-model="selectedSupplier">
                    </model-select> -->
                  <model-list-select
                    :list="suppliers"
                    v-model="selectedSupplier"
                    option-value="id"
                    option-text="name"
                    placeholder="select supplier"
                  >
                  </model-list-select>
                </td>
                <td class="pull-right">
                  <button type="button" class="btn">
                    <i class="fa fa-plus"></i>
                  </button>
                </td>
              </tr>
            </table>
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
              <label for="menu">Người nhập</label>
              <input
                type="text"
                v-model="user['username']"
                class="form-control"
                disabled
              />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 offset-md-8">
            <div class="form-group">
              <label for="menu">Ngày nhập</label>
              <input type="date" class="form-control" placeholder="Ngày" />
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <label for="menu">Nội dung</label>
          <textarea class="form-control" v-model="purchase.title"></textarea>
        </div>
        <div class="col-md-12">
          <form @submit.prevent="addFile" enctype="multipart/form-data">
            <div class="form-group">
              <div class="mb-3">
              <label for="upload">Upload CSV File</label>
              <input type="file" class="form-control" v-on:change="onChange" />
              <br>
              <button type="submit" class="btn btn-primary">Import</button>
              </div>
            </div>
          </form>
        
      </div>
      </div>
    </div>
    <div class="card mt-3 card-info">
      <div class="card-header">
        <h3 class="card-title">Chi tiết</h3>
      </div>

      <div class="row">
        <div class="offset-md-2 col-md-8">
          <model-list-select
            :list="products"
            v-model="selectedProduct"
            option-value="id"
            option-text="name"
            placeholder="select product"
          >
          </model-list-select>
        </div>
        <button type="button" class="btn">
          <i class="fa fa-plus"></i>
          New Product
        </button>
      </div>

      <label for="menu">Danh sách sản phẩm</label>
      <div>
        <table class="table text-center">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Import Price</th>
              <th>Quantity</th>
              <th>Total Price</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="product in selectedProducts"
              :key="product['product_id']"
            >
              <td>{{ product["id"] }}</td>
              <td>{{ product["name"] }}</td>
              <td>${{ product["import_price"] }}</td>
              <td>
                <input
                  type="number"
                  :value="product['quantity']"
                  v-on:input="changeTotal(product['id'], $event)"
                />
              </td>
              <td>${{ product["total_money"] }}</td>
            </tr>
          </tbody>
        </table>
        <div class="row">
          <label class="col-md-2 offset-md-8">Item: {{ totalItem }}</label>
          <label class="col-md-2">Total: ${{ total }}</label>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary pull-right" @click.prevent="save()">
          Lưu
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ModelSelect, ModelListSelect } from "vue-search-select";

export default {
  data() {
    return {
      file:null,
      purchase: {},
      selectedProduct: {},
      selectedProducts: [],
      products: [],
      suppliers: [],
      selectedSupplier: {},
      stores: [],
      selectedStore: {},
      user: {},
    };
  },
  computed: {
    totalItem() {
      let totalItem = 0;
      this.selectedProducts.forEach((item) => {
        totalItem += parseInt(item.quantity);
      });
      return totalItem;
    },
    total() {
      let total = 0;
      this.selectedProducts.forEach((item) => {
        total += item.quantity * item.import_price;
      });
      return total;
    },
  },
  watch: {
    selectedProduct(newVal, oldVal) {
      if (this.selectedProducts.findIndex((x) => x.id == newVal.id) >= 0) {
        let index = this.selectedProducts.findIndex((x) => x.id == newVal.id);
        this.selectedProducts[index].quantity++;
        this.selectedProducts[index].total_money =
          this.selectedProducts[index].import_price *
          this.selectedProducts[index].quantity;
      } else {
        let selected = {
          id: newVal["id"],
          name: newVal["name"],
          import_price: newVal["import_price"],
          quantity: 1,
          total_money: newVal["import_price"],
        };
        this.selectedProducts.push(selected);
      }

      console.log(this.selectedProducts);
    },
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/suppliers/list";
    this.axios.get(uri).then((response) => {
      this.suppliers = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/stores/list";
    this.axios.get(uri).then((response) => {
      this.stores = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/products/list";
    this.axios.get(uri).then((response) => {
      this.products = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/users/get-user-login";
    this.axios.get(uri).then((response) => {
      this.user = response.data;
    });
  },
  methods: {
    onChange(e) {
      this.file = e.target.files[0];
    },
    addFile(){
      const data = new FormData();
      data.append("file", this.file);
      let uri = `http://127.0.0.1:8000/admin/purchases/add-file/`;
      this.axios.post(uri, data).then((response) => {
        console.log(response.data);
        this.selectedProducts = response.data;
      });
    },
    resetSelectedProduct() {
      this.selectedProduct = {};
    },
    changeTotal(id, event) {
      let index = this.selectedProducts.findIndex((x) => x.id == id);
      var quantity = event.target.value;
      if (quantity >= 0) {
        this.selectedProducts[index].quantity = quantity;
        this.selectedProducts[index].total_money =
          this.selectedProducts[index].import_price *
          this.selectedProducts[index].quantity;
      } else {
        this.selectedProducts.splice(index, 1);
      }
    },
    save() {
      this.purchase.stock_id = this.selectedStore.id;
      this.purchase.place_order = this.selectedSupplier.name;
      console.log(this.purchase);
      try {
        let uri = "http://127.0.0.1:8000/admin/purchases/new-purchase";
        this.axios.post(uri, this.purchase).then((response) => {
          this.purchase = response.data;
          this.addProduct(this.purchase.id);
        });
      } catch (error) {
        if (error.response.status === 403) {
            console.log(error.response)
            alert(error.response.data.message);
          }
        console.error(error.response.data); // NOTE - use "error.response.data` (not "error")
      }
    },
    addProduct(id) {
      let uri = `http://127.0.0.1:8000/admin/purchases/add-product/${id}`;
      this.axios.post(uri, this.selectedProducts).then((response) => {
        console.log(response.data);
        this.$router.push({ name: "purchases.list" });
      });
    },
  },
  components: {
    ModelSelect,
    ModelListSelect,
  },
};
</script>


