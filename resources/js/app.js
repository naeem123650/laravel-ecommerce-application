window._ = require("lodash");

window.Vue = require("vue");

window.axios = require("axios");

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


import Vue from 'vue';
import VueSwal from 'vue-swal'
Vue.use(VueSwal)

Vue.component("product-attributes", require("./components/ProductAttributes.vue").default);

const app = new Vue({
    el:"#app"
});
