import Vue from 'vue';
import axios from 'axios';
import vuetifyInstance from './plugins/Vuetify'
import dayjs from 'dayjs';
import '@mdi/font/css/materialdesignicons.min.css';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// window.Telescope.basePath = '/' + window.Telescope.path;

// let routerBasePath = window.Telescope.basePath + '/';

// if (window.Telescope.path === '' || window.Telescope.path === '/') {
//     routerBasePath = '/';
//     window.Telescope.basePath = '';
// }

// const router = new VueRouter({
//     routes: Routes,
//     mode: 'history',
//     base: routerBasePath,
// });

// Vue.component('vue-json-pretty', VueJsonPretty);
// Vue.component('related-entries', require('./components/RelatedEntries.vue').default);
// Vue.component('index-screen', require('./components/IndexScreen.vue').default);
// Vue.component('preview-screen', require('./components/PreviewScreen.vue').default);
Vue.component('Microscope', require('./components/index.vue').default);

Vue.prototype.$dayjs = dayjs

new Vue({
	el: '#app',
	vuetify: vuetifyInstance,
});
