<template>
  <div class="card card-primary mt-3">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <h1>Create New Product</h1>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <form @submit.prevent="addProduct" enctype="multipart/form-data">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="menu">Tên Sản Phẩm</label>
              <input
                type="text"
                class="form-control"
                placeholder="Nhập tên sản phẩm"
                v-model="product.name"
              />
              <!-- <span v-if="errors.name" class="invalid-feedback" role="alert">
                <strong>{{ errors.name[0] }}</strong>
              </span> -->
            </div>
            <div class="alert alert-danger" v-if="errors && errors.name">
              {{ errors.name[0] }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Danh mục</label>
              <select class="form-control" v-model="product.category_id">
                <option
                  v-for="category in categories"
                  v-bind:value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
            <div class="alert alert-danger" v-if="errors && errors.category_id">
              {{ errors.category_id[0] }}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tên nhãn hiệu</label>
              <select class="form-control" v-model="product.brand_id">
                <option v-for="brand in brands" v-bind:value="brand.id">
                  {{ brand.name }}
                </option>
              </select>
            </div>
            <div class="alert alert-danger" v-if="errors && errors.brand_id">
              {{ errors.brand_id[0] }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Nhân viên tạo</label>
              <input :value="user.name" class="form-control" disabled />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Giá sản phẩm</label>
              <input
                type="number"
                class="form-control"
                v-model="product.price"
              />
            </div>
            <div class="alert alert-danger" v-if="errors && errors.price">
              {{ errors.price[0] }}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Giá nhập</label>
              <input
                type="number"
                class="form-control"
                v-model="product.import_price"
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Màu sắc</label>
              <input
                type="text"
                class="form-control"
                v-model="product.corlor"
              />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Mô tả</label>
          <textarea
            v-model="product.description"
            class="form-control"
          ></textarea>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Upload</span>
          </div>
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              v-on:change="onChange"
            />
            <label class="custom-file-label" for="inputGroupFile01"
              >Choose file</label
            >
          </div>
        </div>

        <!-- <div class="form-group">
          <label for="upload">Ảnh</label>
          <input type="file" class="form-control" v-on:change="onChange" />
          <div id="image_show"></div>
          <input type="hidden" id="photo" />
        </div> -->
        <div class="form-group">
          <label>Kích Hoạt</label>
          <div class="form-check">
            <input
              class="form-check-input"
              value="1"
              type="radio"
              v-model="product.active"
              id="active"
              checked=""
            />
            <label class="form-check-label" for="active">Có</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              value="0"
              type="radio"
              v-model="product.active"
              id="no_active"
            />
            <label class="form-check-label" for="no_active">Không</label>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      product: {},
      categories: [],
      brands: [],
      errors: [],
      user: {},
    };
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/categories/list";
    this.axios.get(uri).then((response) => {
      this.categories = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/brands/list";
    this.axios.get(uri).then((response) => {
      this.brands = response.data;
    });
    uri = "http://127.0.0.1:8000/admin/users/get-user-login";
    this.axios.get(uri).then((response) => {
      this.user = response.data;
    });
  },
  methods: {
    onChange(e) {
      this.product["photo"] = e.target.files[0];
    },
    addProduct() {
      const data = new FormData();
      if (this.product.name) {
        data.append("name", this.product["name"]);
      }
      if (this.product.category_id) {
        data.append("category_id", this.product["category_id"]);
      }
      if (this.product.brand_id) {
        data.append("brand_id", this.product["brand_id"]);
      }
      if (this.product.price) {
        data.append("price", this.product["price"]);
      }
      data.append("description", this.product["description"]);
      data.append("import_price", this.product["import_price"]);
      data.append("created_by", this.user["id"]);
      data.append("active", this.product["active"]);
      data.append("photo", this.product["photo"]);
      console.log(data);

      let uri = "http://127.0.0.1:8000/admin/products/add-product";
      this.axios
        .post(uri, data)
        .then((response) => {
          this.$router.push({ name: "products" });
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          }
          if (error.response.status === 403) {
            console.log(error.response);
            alert(error.response.data.message);
          }
        });
    },
  },
  components: {},
};
</script>
