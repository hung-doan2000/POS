<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/orders/pos" class="brand-link">
        <img src="/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Rhust-app</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (Auth::user()->photo)
                <img class="img-circle elevation-2" src="{{ asset(Auth::user()->photo) }}" alt="User Image">
                @else<img src="/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                     <li class="nav-item">
                     <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="fas fa-chart-bar" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Dashboard
                        </p>
                    </a>
                     </li>
                     <li class="nav-item">
                        <a href="/orders/pos" class="nav-link">
                            <i class="far fa-circle " style="margin-left:4px">></i>
                           <p style="margin-left:5px">
                               POS
                           </p>
                       </a>
                        </li>
                <li class="nav-item">
                    <a href="{{route('admin.categories.index')}}" class="nav-link">
                        <i class="fab fa-product-hunt" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Danh mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <!-- product-->
                <li class="nav-item">
                    <a href="{{route('admin.products.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <!-- end product-->

                <!-- banner-->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-image" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Banner
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.banners.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.banners.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Banner</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end banner-->

                <!-- brand-->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-copyright" style="margin-left:5px"></i>
                        <p style="margin-left:6px">
                            Thương Hiệu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.brands.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Thương Hiệu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Thương Hiệu</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end brand-->
                <!-- store-->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-store-alt" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Cửa Hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.stores.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Cửa Hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.stores.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Cửa hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end store-->
                <li class="nav-item">
                    <a href="{{route('admin.warehouses.index')}}" class="nav-link">
                        <i class="fas fa-warehouse" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Nhà kho
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-money-check-alt" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Đơn nhập hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo đơn hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đơn hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.payments')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thanh toán</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shipping-fast" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Vận chuyển hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.transfers.list')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đơn chuyển hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.transfers.orders_list')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn hàng cần nhận</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.products.quotation')}}" class="nav-link">
                        <i class="fas fa-money-bill" style="margin-left:4px"></i>
                        <p style="margin-left:5px">
                            Quotation
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-rss" style="margin-left:5px"></i>
                        <p style="margin-left:5px">
                            Feeds
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.feeds.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mapping</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.feeds.upfileView')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Up files</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            Thêm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.extras.manage-user')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quản lý nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.extras.create-user')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo nhân viên</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cart-plus"></i>
                        <p style="margin-left: 10px">
                            Giỏ hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.cart-list')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đơn hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p style="margin-left: 10px">
                            Khách hàng
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
