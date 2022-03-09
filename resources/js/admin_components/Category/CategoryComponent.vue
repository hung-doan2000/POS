<template>
  <div class="col-md-12">
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">CATEGORY</h3>
        <button
          type="button"
          class="btn btn-info btn-sm"
          style="float: right"
          @click="showModal"
        >
          Create new Category
        </button>
      </div>
      <br>
      <table id="example" class="display nowrap table" width="100%">
        <thead>
          <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Description</td>
            <td>Tax</td>
            <td>Unit</td>
            <td>Photo</td>
            <td>&nbsp;</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td>{{ category.description }}</td>
            <td>{{ category.tax }}</td>
            <td>{{ category.unit }}</td>
            <td>
              <img
                class="img-thumbnail"
                width="60px"
                :src="category['photo']"
              />
            </td>
            <td>
              <button
                class="btn btn-primary btn-sm"
                @click="showEditModal(category['id'])"
              >
                <i class="fas fa-edit"></i>
              </button>
              <a
                class="btn btn-danger btn-sm"
                @click="showDeleteModal(category['id'])"
              >
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
      <Modal v-show="isModalVisible" @close="closeModal">
        <div class="card-header" slot="header">
          <h3 class="card-title">Create new Category</h3>
        </div>
        <div slot="body">
          <form @submit.prevent="addCategory" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tên Danh Mục</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Nhập tên danh mục"
                      v-model="category.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Danh Mục Cha</label>
                    <select class="form-control" v-model="category.parent_id">
                      <option value="0" selected>Danh mục cha</option>
                      <option
                        v-for="parCate in categories"
                        :key="parCate['id']"
                        v-bind:value="parCate['id']"
                      >
                        {{ parCate["name"] }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Mô tả danh mục</label>
                <textarea
                  class="form-control"
                  v-model="category.description"
                ></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Thuế</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="category.tax"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Đơn vị</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="category.unit"
                    />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="upload">Ảnh</label>
                <input
                  type="file"
                  class="form-control"
                  v-on:change="onChange"
                />
                <div id="image_show"></div>
                <input type="hidden" id="photo" name="photo" />
              </div>
            </div>

            <div class="card-footer">
              <button class="btn btn-primary">Tạo Danh Mục</button>
            </div>
          </form>
        </div>
      </Modal>
      <Modal v-show="isEditModalVisible" @close="closeEditModal">
        <div class="card-header" slot="header">
          <h3 class="card-title">Edit Category</h3>
        </div>
        <div slot="body">
          <form
            @submit.prevent="editCategory(categoryEdit.id)"
            enctype="multipart/form-data"
          >
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tên Danh Mục</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Nhập tên danh mục"
                      v-model="categoryEdit.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Danh Mục Cha</label>
                    <select
                      class="form-control"
                      v-model="categoryEdit.parent_id"
                    >
                      <option value="0">Danh mục cha</option>
                      <option
                        v-for="parCate in categories"
                        :key="parCate['id']"
                        v-bind:value="parCate['id']"
                      >
                        {{ parCate["name"] }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Mô tả danh mục</label>
                <textarea
                  class="form-control"
                  v-model="categoryEdit.description"
                ></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Thuế</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="categoryEdit.tax"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Đơn vị</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="categoryEdit.unit"
                    />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="upload">Ảnh</label>
                <input
                  type="file"
                  class="form-control"
                  id="upload"
                  v-on:change="onChangeEdit"
                />
                <div id="image_show">
                  <img :src="categoryEdit['photo']" width="100px" />
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button class="btn btn-primary">Sửa Danh Mục</button>
            </div>
          </form>
        </div>
      </Modal>
      <Modal v-show="isDeleteModalVisible" @close="closeDeleteModal">
        <div class="card-header" slot="header">
          <h3 class="card-title">Delete Category</h3>
        </div>
        <div class="card-body" slot="body">Bạn có muốn xóa Category này?</div>
        <div class="card-footer" slot="footer">
          <button
            class="modal-default-button btn-warning"
            @click="deleteCate(categoryEdit.id)"
          >
            Delete
          </button>
          <button
            class="modal-default-button btn-error"
            @click="closeDeleteModal"
          >
            Exit
          </button>
        </div>
      </Modal>
    </div>
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
      category: {},
      categoryEdit: {},
      categories: [],
      isModalVisible: false,
      isEditModalVisible: false,
      isDeleteModalVisible: false,
    };
  },
  created() {},
  mounted() {
    fetch("http://127.0.0.1:8000/admin/categories/list")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.categories = data;
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
        },500);
      });
  },
  methods: {
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    showEditModal(id) {
      var item = this.categories.find((item) => item.id == id);
      this.categoryEdit = item;
      this.isEditModalVisible = true;
      console.log(this.categoryEdit);
    },
    closeEditModal() {
      this.isEditModalVisible = false;
    },
    showDeleteModal(id) {
      var item = this.categories.find((item) => item.id == id);
      this.categoryEdit = item;
      this.isDeleteModalVisible = true;
    },
    closeDeleteModal() {
      this.isDeleteModalVisible = false;
    },
    onChange(e) {
      this.category["photo"] = e.target.files[0];
    },
    onChangeEdit(e) {
      this.categoryEdit["photo"] = e.target.files[0];
      console.log(this.categoryEdit["photo"]);
    },
    addCategory() {
      const data = new FormData();
      data.append("name", this.category["name"]);
      data.append("parent_id", this.category["parent_id"]);
      data.append("description", this.category["description"]);
      data.append("tax", this.category["tax"]);
      data.append("unit", this.category["unit"]);
      data.append("photo", this.category["photo"]);
      console.log(data);
      try {
        let uri = "http://127.0.0.1:8000/admin/categories/add-cate";
        this.axios.post(uri, data).then((response) => {
          let newCate = response.data;
          console.log(response.data);
          this.categories.push(newCate);
          this.category = {};
          this.closeModal();
        });
      } catch (error) {
        if (error.response.status === 403) {
            console.log(error.response)
            alert(error.response.data.message);
          }
        console.error(error.response.data); // NOTE - use "error.response.data` (not "error")
      }
    },
    editCategory(id) {
      console.log(this.categoryEdit);
      const dataEdit = new FormData();
      dataEdit.append("name", this.categoryEdit["name"]);
      dataEdit.append("parent_id", this.categoryEdit["parent_id"]);
      dataEdit.append("description", this.categoryEdit["description"]);
      dataEdit.append("tax", this.categoryEdit["tax"]);
      dataEdit.append("unit", this.categoryEdit["unit"]);
      dataEdit.append("photo", this.categoryEdit["photo"]);
      console.log(dataEdit);
      try {
        let uri = `http://127.0.0.1:8000/admin/categories/edit-cate/${id}`;
        this.axios.post(uri, dataEdit).then((response) => {
          console.log(response.data);
          let index = this.categories.findIndex((x) => x.id == id);
          this.categories[index] = response.data;
          this.closeEditModal();
          //this.categories.push(this.category);
        });
      } catch (error) {
        if (error.response.status === 403) {
            console.log(error.response)
            alert(error.response.data.message);
          }
        console.error(error.response.data); // NOTE - use "error.response.data` (not "error")
      }
    },
    deleteCate(id) {
      console.log(this.categoryEdit);
      try {
        let uri = `http://127.0.0.1:8000/admin/categories/delete-cate/${id}`;
        this.axios.delete(uri).then((response) => {
          console.log(response.data);
          //this.categories.push(this.category);
          let index = this.categories.findIndex((x) => x.id == id);
          this.categories.splice(this.categories.indexOf(index), 1);
          this.isDeleteModalVisible = false;
        });
      } catch (error) {
        if (error.response.status === 403) {
            console.log(error.response)
            alert(error.response.data.message);
          }
        console.error(error.response.data); // NOTE - use "error.response.data` (not "error")
      }
    },
  },
  components: {
    Modal,
  },
};
</script>

