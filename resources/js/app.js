/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from "vue";
import VueToastr from "vue-toastr";
Vue.use(VueToastr);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('agregar-al-carrito', require('./components/AgregarAlCarrito.vue').default);
Vue.component('carrito-compras', require('./components/CarritoCompras.vue').default);
Vue.component('checkout', require('./components/CheckoutCarrito.vue').default);
Vue.component('response-checkout', require('./components/ResponseCheckout.vue').default);
Vue.component('payment', require('./components/PaymentCar.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
