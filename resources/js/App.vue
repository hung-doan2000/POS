<template>
  <div >
    <section class="header-main">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3">
            <div class="brand-wrap">
              <img class="logo" src="/images/Logo-1.jpg" />
              <h2 class="logo-text">RHUST POS</h2>
            </div>
            <!-- brand-wrap.// -->
          </div>
          <div class="col-lg-6 col-sm-6">
            <form action="#" class="search-wrap">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" />
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <!-- search-wrap .end// -->
          </div>
          <!-- col.// -->
          <div class="col-lg-3 col-sm-6">
            <div class="widgets-wrap d-flex justify-content-end">
              <div class="widget-header">
                <a href="#" class="icontext">
                  <a
                    href="/admin/vue/dashboard"
                    class="btn btn-primary m-btn m-btn--icon m-btn--icon-only"
                  >
                    <i class="fa fa-home"></i>
                  </a>
                </a>
              </div>
              <!-- widget .// -->
              <div class="widget-header dropdown">
                <a
                  href="#"
                  class="ml-3 icontext"
                  data-toggle="dropdown"
                  data-offset="20,10"
                >
                  <img
                    :src="user.photo"
                    class="avatar"
                    alt=""
                  />
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#"
                    ><i class="fa fa-sign-out-alt"></i> Logout</a
                  >
                </div>
                <!--  dropdown-menu .// -->
              </div>
              <!-- widget  dropdown.// -->
            </div>
            <!-- widgets-wrap.// -->
          </div>
          <!-- col.// -->
          <!-- row.// -->
        </div>
      </div>
      <!-- container.// -->
    </section>
    <br />
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-active {
  opacity: 0;
}
.avatar {
  vertical-align: middle;
  width: 35px;
  height: 35px;
  border-radius: 50%;
}
.bg-default, .btn-default{
	background-color: #f2f3f8;
}
.btn-error{
	color: #ef5f5f;
}
</style>

<script>
export default {
  data() {
    return {
      user : {},
      active: null
    };
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/users/get-user-login";
    this.axios.get(uri).then((response) => {
      this.user = response.data;
    });
  },
};
</script>
