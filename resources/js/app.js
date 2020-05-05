import Vue from "vue";
import axios from "axios";
import VueMasonry from 'vue-masonry-css';
import VModal from 'vue-js-modal';
// import InstantSearch from 'vue-instantsearch';

// Vue.use(InstantSearch);
Vue.use(VueMasonry);
Vue.use(VModal);

window.Vue = Vue;
window.axios = axios;
window.Event = new Vue();

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('avatar', require('./components/Avatar.vue').default);
Vue.component('categories', require('./components/Categories.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('navdrawer', require('./modals/Navdrawer.vue').default);
Vue.component('need-card', require('./components/NeedCard.vue').default);
Vue.component('profile-form', require('./views/ProfileForm.vue').default);
Vue.component('tab', require('./components/Tab.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);
Vue.component('tags', require('./components/Tags.vue').default);
Vue.component('tags-input', require('./components/TagsInput.vue').default);
Vue.component('textfield', require('./components/Textfield.vue').default);

const app = new Vue({
    el: '#app',
});
