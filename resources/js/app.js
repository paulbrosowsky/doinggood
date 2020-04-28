import Vue from "vue";
import axios from "axios";
import VueMasonry from 'vue-masonry-css';
// import InstantSearch from 'vue-instantsearch';

// Vue.use(InstantSearch);
Vue.use(VueMasonry);

window.Vue = Vue;
window.axios = axios;
window.Event = new Vue();

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('categories', require('./components/Categories.vue').default);
Vue.component('need-card', require('./components/NeedCard.vue').default);


const app = new Vue({
    el: '#app',
});
