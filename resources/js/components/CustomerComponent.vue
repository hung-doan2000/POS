<template>
  <section class="section-content padding-y-sm bg-default">
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
            <button class="btn btn-primary">Tạo</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      customer: {
        name: "",
        phone: "",
        email: "",
        address: "",
      },
    };
  },
  methods: {
    addCustomer() {
      let uri = "http://127.0.0.1:8000/admin/customers/create";
      console.log(this.customer);
      this.axios.post(uri, this.customer).then((response) => {
        this.$router.push({ name: "pos" });
      });
    },
  },
};
</script>
