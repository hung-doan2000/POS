<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Đổi mật khẩu</div>

          <div class="card-body">
            <form @submit.prevent="changePassword">
              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Mật khẩu cũ</label
                >
                <div class="col-md-6">
                  <input
                    type="password"
                    class="form-control"
                    v-model="user.current_password"
                    autocomplete="current_password"
                  />
                  <div
                    class="alert alert-danger"
                    v-if="errors && errors.current_password"
                  >
                    {{ errors.current_password[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Mật khẩu mới</label
                >
                <div class="col-md-6">
                  <input
                    type="password"
                    class="form-control "
                    v-model="user.password"
                    autocomplete="password"
                  />
                  <div
                    class="alert alert-danger"
                    v-if="errors && errors.password"
                  >
                    {{ errors.password[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Xác nhận mật khẩu</label
                >
                <div class="col-md-6">
                  <input
                    type="password"
                    class="form-control"
                    v-model="user.password_confirmation"
                    autocomplete="password_confirmation"
                  />
                  <div
                    class="alert alert-danger"
                    v-if="errors && errors.password_confirmation"
                  >
                    {{ errors.password_confirmation[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Cập nhật
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {},
      errors: [],
    };
  },
  created() {},
  methods: {
    changePassword() {
      let uri = `http://127.0.0.1:8000/admin/users/change-password/${this.$route.params.id}`;
      this.axios
        .post(uri, this.user)
        .then((response) => {
          console.log(response);
          this.$router.push({ name: "dashboard" });
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          }
        });
    },
  },
  components: {},
};
</script>