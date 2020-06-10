import Vue from "vue";
import axios from "axios";
import VueMasonry from 'vue-masonry-css';
import VModal from 'vue-js-modal';
import  Datetime from 'vue-datetime';
import {DateTime} from 'luxon';
import 'vue-datetime/dist/vue-datetime.css';
// import InstantSearch from 'vue-instantsearch';

// Vue.use(InstantSearch);
Vue.use(VueMasonry);
Vue.use(VModal);
Vue.use(Datetime);

window.Vue = Vue;
window.axios = axios;
window.Event = new Vue();
window.DateTime = DateTime;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.flash = function(message, level = 'success') {
    window.Event.$emit('flash', { message, level });
};

Vue.component('accordion', require('./components/Accordion.vue').default);
Vue.component('avatar', require('./components/Avatar.vue').default);
Vue.component('categories', require('./components/Categories.vue').default);
Vue.component('category-select', require('./components/CategorySelect.vue').default);
Vue.component('confirm-dialog', require('./modals/ConfirmDialog.vue').default);
Vue.component('DatetimeInput', require('./components/DatetimeInput.vue').default);
Vue.component('edit-profile', require('./views/EditProfile.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('help-card', require('./components/HelpCard.vue').default);
Vue.component('image-upload', require('./components/ImageUpload.vue').default);
Vue.component('loading', require('./components/Loading.vue').default);
Vue.component('message-form', require('./modals/MessageForm.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('navdrawer', require('./modals/Navdrawer.vue').default);
Vue.component('need-action-buttons', require('./components/NeedActionButtons.vue').default);
Vue.component('need-card', require('./components/NeedCard.vue').default);
Vue.component('need-form', require('./views/NeedForm.vue').default);
Vue.component('need-owner-buttons', require('./components/NeedOwnerButtons.vue').default);
Vue.component('tab', require('./components/Tab.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);
Vue.component('tags', require('./components/Tags.vue').default);
Vue.component('tags-input', require('./components/TagsInput.vue').default);
Vue.component('text-editor', require('./components/TextEditor.vue').default);
Vue.component('textfield', require('./components/Textfield.vue').default);

const app = new Vue({
    el: '#app',
});
