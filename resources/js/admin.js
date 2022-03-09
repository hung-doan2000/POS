require('./bootstrap');

import Vue from 'vue';


import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
import 'vue-search-select/dist/VueSearchSelect.css';
//import 'materialize-css';
//import 'materialize-css/dist/css/materialize.css';

import Admin from './Admin.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import DashboardComponent from './admin_components/Dashboard/DashboardComponent.vue';
import CategoryComponent from './admin_components/Category/CategoryComponent.vue';
import ProductComponent from './admin_components/Product/ProductComponent.vue';
import CustomerComponent from './admin_components/Customer/CustomerComponent.vue';
import CustomerListComponent from './admin_components/Customer/CustomerListComponent.vue';
import CustomerGroupComponent from './admin_components/Customer/CustomerGroupComponent.vue';
import CreateProductComponent from './admin_components/Product/CreateProductComponent.vue';
import EditProductComponent from './admin_components/Product/EditProductComponent.vue';
import PurchaseComponent from './admin_components/Purchase/PurchaseComponent.vue';
import PurchaseListComponent from './admin_components/Purchase/PurchaseListComponent.vue';
import StoreComponent from './admin_components/Store/StoreComponent.vue';
import WareHouseComponent from './admin_components/Store/WareHouseComponent.vue';
import UserListComponent from './admin_components/User/UserListComponent.vue';
import UserComponent from './admin_components/User/UserComponent.vue';
import UserEditComponent from './admin_components/User/UserEditComponent.vue';
import UserCreateComponent from './admin_components/User/UserCreateComponent.vue';
import EditComponent from './admin_components/User/EditComponent.vue';
import ChangePasswordComponent from './admin_components/User/ChangePasswordComponent.vue';
Vue.use(VueAxios, axios);
Vue.prototype.$user = document.querySelector("meta[name='user_id']").getAttribute('content');

const routes = [
    {
        name: 'example',
        path: '/admin/vue/example',
        component: ExampleComponent
    },
    {
        name: 'dashboard',
        path: '/admin/vue/dashboard',
        component: DashboardComponent,
    },
    {
        name: 'categories',
        path: '/admin/vue/categories',
        component: CategoryComponent,
    },
    {
        name: 'products',
        path: '/admin/vue/products',
        component: ProductComponent,
    },
    {
        name: 'products.create',
        path: '/admin/vue/products/create',
        component: CreateProductComponent,
    },
    {
        name: 'products.edit',
        path: '/admin/vue/products/edit/:id',
        component: EditProductComponent,
    },
    {
        name: 'purchases.create',
        path: '/admin/vue/purchases/create',
        component: PurchaseComponent,
    },
    {
        name: 'purchases.list',
        path: '/admin/vue/purchases/list',
        component: PurchaseListComponent,
    },
    {
        name: 'customers-list',
        path: '/admin/vue/customer-list',
        component: CustomerListComponent,
    },
    {
        name: 'customer',
        path: '/admin/vue/customer/:id',
        component: CustomerComponent,
    },
    {
        name: 'customer-group',
        path: '/admin/vue/customer-group',
        component: CustomerGroupComponent,
    },
    {
        name: 'store',
        path: '/admin/vue/store',
        component: StoreComponent,
    },
    {
        name: 'warehouse',
        path: '/admin/vue/warehouse',
        component: WareHouseComponent,
    },
    {
        name: 'user-list',
        path: '/admin/vue/user-list/:id',
        component: UserListComponent,
    },
    {
        name: 'user-list',
        path: '/admin/vue/user-list',
        component: UserListComponent,
    },
    {
        name: 'user',
        path: '/admin/vue/user/:id',
        component: UserComponent,
    },
    {
        name: 'user-edit',
        path: '/admin/vue/user-edit/:id',
        component: UserEditComponent,
    },
    {
        name: 'user-create',
        path: '/admin/vue/user-create',
        component: UserCreateComponent,
    },
    {
        name: 'change-password',
        path: '/admin/vue/change-password/:id',
        component: ChangePasswordComponent,
    },
    {
        name: 'edit-user',
        path: '/admin/vue/edit-user/:id',
        component: EditComponent,
    },

];

const router = new VueRouter({ mode: 'history', routes: routes });

const admin = new Vue(Vue.util.extend({ router }, Admin)).$mount('#admin');
