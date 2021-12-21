window.Vue = require('vue');
window.axios = require('axios');

Vue.component('show-component', require('./components/Show.vue').default);
Vue.component('app-component', require('./components/App.vue').default);
Vue.component('cart-component', require('./components/Cart.vue').default);

const app = new Vue({
    el: '#app',
});