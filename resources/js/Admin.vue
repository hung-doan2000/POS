<template>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <div class="dropdown" style="margin-right:6px">
                    <a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <router-link :to="{ name: 'edit-user', params: { id: user.id } }"  class="dropdown-item" >Chỉnh sửa thông tin</router-link>
                        <router-link :to="{ name: 'change-password', params: { id: user.id } }" class="dropdown-item" href="">Đổi mật khẩu</router-link>
                        <a class="dropdown-item" href="/admin/logout">Đăng xuất</a>
                    </div>
                </div>
            </ul>
        </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/orders/pos" class="brand-link">
        <img
          src="/template/dist/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">Rhust-app</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img
              :src="user.photo"
              class="img-circle elevation-2"
              alt="User Image"
            />
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ user.name }}</a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
            <li class="nav-item" >
              <router-link to="/admin/vue/dashboard" class="nav-link" >
                <i class="fas fa-chart-bar" style="margin-left: 4px"></i>
                <p style="margin-left: 5px">Dashboard</p>
              </router-link>
            </li>
            <li class="nav-item">
              <a href="/orders/pos" class="nav-link">
                <i class="far fa-circle" style="margin-left: 4px">></i>
                <p style="margin-left: 5px">POS</p>
              </a>
            </li>
            <li class="nav-item">
              <router-link to="/admin/vue/categories" class="nav-link"
                ><i class="fab fa-product-hunt" style="margin-left: 4px"></i>
                <p style="margin-left: 5px">
                  Danh mục
                  <i class="right fas fa-angle-left"></i></p
              ></router-link>
            </li>
            <!-- product-->
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>
                  Sản phẩm
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/admin/vue/products/create" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Thêm sản phẩm</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/admin/vue/products" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Danh sách sản phẩm</p>
                  </router-link>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-money-check-alt" style="margin-left: 4px"></i>
                <p style="margin-left: 5px">
                  Đơn nhập hàng
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link
                    to="/admin/vue/purchases/create"
                    class="nav-link"
                  >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tạo đơn hàng</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/admin/vue/purchases/list" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Danh sách đơn hàng</p>
                  </router-link>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-store-alt" style="margin-left: 4px"></i>
                <p style="margin-left: 5px">
                  Cửa hàng
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/admin/vue/store" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Danh sách cửa hàng</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/admin/vue/warehouse" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kho</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/admin/vue/user-list" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nhân viên</p>
                  </router-link>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-users" style="margin-left: 4px"></i>
                <p style="margin-left: 5px">
                  Khách hàng
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/admin/vue/customer-list" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Danh sách khách hàng</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/admin/vue/customer-group" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nhóm khách hàng</p>
                  </router-link>
                </li>
              </ul>
            </li>
            <!-- end product-->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        
      
              <transition name="fade">
                <router-view></router-view>
              </transition>
            
          <!-- /.row -->
        
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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
