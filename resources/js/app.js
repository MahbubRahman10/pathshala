

require('./bootstrap');

window.Vue = require('vue');

import Router from './router'

/* Vue Router */
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)
Vue.use(require('vue-moment'));
Vue.component('pagination', require('laravel-vue-pagination'));

var VueCookie = require('vue-cookie');
Vue.use(VueCookie);

const router = new VueRouter({
	routes : Router,
	mode : 'history'
})

const app = new Vue({
    el: '#app',
    router: router
});
