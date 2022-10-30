import '@mdi/font/css/materialdesignicons.min.css';
import axios from 'axios';
import dayjs from 'dayjs';
import Vue from 'vue';
import vuetifyInstance from './plugins/Vuetify'

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
	axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.component('Hubblescope', require('./components/index.vue').default);

Vue.prototype.$dayjs = dayjs

new Vue({
	el: '#app',
	vuetify: vuetifyInstance,
});
