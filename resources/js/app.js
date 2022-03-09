require('./bootstrap');

import Vue from 'vue';


import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
import 'vue-search-select/dist/VueSearchSelect.css';

import App from './App.vue';
Vue.use(VueAxios, axios);


import PosComponent from './components/PosComponent.vue';
import CustomerComponent from './components/CustomerComponent.vue';

const routes = [
    {
        name: 'pos',
        path: '/orders/pos',
        component: PosComponent
    },
    {
        name: 'customer',
        path: '/orders/customer',
        component: CustomerComponent
    }
];

const router = new VueRouter({ mode: 'history', routes: routes });

const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
